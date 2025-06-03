<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Topup;
use App\Models\WalletHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TopupController extends Controller
{

    // Tampilkan daftar top-up
    public function index()
    {
        $query = Topup::with(['santri.user']);

        // Apply filter by source if provided
        if (request()->has('source') && in_array(request()->input('source'), ['admin', 'wali'])) {
            $query->where('source', request()->input('source'));
        }

        $topups = $query->latest()->paginate(10);

        // Get statistics
        $todayTopups = Topup::whereDate('created_at', Carbon::today())
            ->sum('amount');

        $monthTopups = Topup::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

        $totalTransactions = Topup::count();

        return view('admin.topup.index', compact('topups', 'todayTopups', 'monthTopups', 'totalTransactions'));
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
