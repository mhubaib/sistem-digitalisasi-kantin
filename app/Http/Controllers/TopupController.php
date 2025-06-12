<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Topup;
use App\Models\WalletHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\NotificationService;

class TopupController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    // Tampilkan daftar top-up
    public function index(Request $request)
    {
        $query = Topup::with(['santri.user']);

        // Filter by santri
        if ($request->filled('santri_id')) {
            $query->where('santri_id', $request->santri_id);
        }

        // Filter by method
        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        // Filter by source
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $topups = $query->latest()->paginate(10);

        // Get statistics
        $todayTopups = Topup::whereDate('created_at', Carbon::today())
            ->sum('amount');

        $monthTopups = Topup::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

        $totalTransactions = Topup::count();

        // Get all santris for filter dropdown
        $santris = Santri::with('user')
            ->where('status', 'approved')
            ->get();

        return view('admin.topup.index', compact('topups', 'todayTopups', 'monthTopups', 'totalTransactions', 'santris'));
    }

    // Tampilkan form create top-up
    public function create()
    {
        $santris = Santri::with('user')
            ->where('status', 'approved')
            ->get();
        return view('admin.topup.create', compact('santris'));
    }

    // Simpan top-up saldo
    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'amount'    => 'required|numeric|min:1000',
            'method'    => 'required|in:cash,transfer,manual,lainnya',
        ]);

        DB::beginTransaction();

        try {
            // Remove thousand separator and convert to integer
            $amount = (int) str_replace(',', '', $request->amount);

            // Determine the source based on authenticated user's role
            $source = Auth::user()->role === 'wali' ? 'wali' : 'admin';

            $topup = Topup::create([
                'santri_id'  => $request->santri_id,
                'amount'     => $amount,
                'method'     => $request->method,
                'created_by' => Auth::id(),
                'source'     => $source,
            ]);

            $santri = Santri::findOrFail($request->santri_id);
            $santri->increment('saldo', $amount);

            WalletHistory::create([
                'santri_id'   => $santri->id,
                'type'        => 'topup',
                'method'      => $request->method,
                'amount'      => $amount,
                'description' => 'Top-up saldo',
                'created_by'  => Auth::id(),
            ]);

            DB::commit();

            // Create notification for santri if topup is from admin
            if ($source === 'admin') {
                $notification = $this->notificationService->createForSantri(
                    $santri->user_id,
                    'topup',
                    'Top-up Saldo Berhasil',
                    'Admin telah melakukan top-up saldo sebesar Rp ' . number_format($amount, 0, ',', '.') . ' ke akun Anda.',
                    [
                        'amount' => $amount,
                        'method' => $request->method,
                        'topup_id' => $topup->id
                    ]
                );
            }

            return redirect()
                ->route('admin.topup.index')
                ->with('success', 'Top-up berhasil dilakukan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
