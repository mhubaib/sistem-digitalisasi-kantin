<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Santri;
use App\Models\Topup;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get active santri count and total saldo
        $activeSantri = Santri::join('users', 'santris.user_id', '=', 'users.id')
            ->where('users.active', true)
            ->select('santris.id', 'santris.saldo');

        $totalSantri = $activeSantri->count();
        $totalSaldo = $activeSantri->sum('saldo');

        return view('admin.dashboard', [
            'totalSantri' => $totalSantri,
            'totalSaldo' => $totalSaldo,
            'todayIncome' => Transaction::whereDate('created_at', Carbon::today())->sum('total'),
            'recentTransactions' => Transaction::with('santri.user')
                ->latest()
                ->take(5)
                ->get(),
            'notifications' => $notifications,
            'totalExpenses' => Expense::whereDate('expense_date', Carbon::today())->sum('amount'),
        ]);
    }

    public function santri()
    {
        $santri = Auth::user()->santri;

        return view('santri.dashboard', [
            'santri' => $santri,
            'totalTransactions' => $santri?->transactions()->count() ?? 0,
            'recentTransactions' => $santri?->transactions()
                ->latest()
                ->take(5)
                ->get() ?? collect(),
        ]);
    }

    public function wali()
    {
        $user = Auth::user();
        $santris = $user->santris ?? collect();
        $santriIds = $santris->pluck('id');

        return view('wali.dashboard', [
            'santris' => $santris,
            'totalSaldo' => $santris->sum('saldo'),
            'recentTransactions' => Transaction::whereIn('santri_id', $santriIds)
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }

    public function products()
    {
        $products = Product::all();
        return view('santri.product.index', compact('products'));
    }

    public function transactions(Request $request)
    {
        $santri = Auth::user()->santri;
        $query = $santri->transactions();

        // Apply date filtering if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->latest()->get();
        $totalSpending = $transactions->sum('total');
        $transactionItems = TransactionItem::whereIn('transaction_id', $transactions->pluck('id'))->get();

        return view('santri.transactions.index', [
            'transactions' => $transactions,
            'totalSpending' => $totalSpending,
            'transactionItems' => $transactionItems,
        ]);
    }

    public function topups(Request $request)
    {
        $santri = Auth::user()->santri;
        $query = Topup::where('santri_id', $santri->id)->with('createdBy');

        // Apply date filtering if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $topups = $query->latest()->get();

        return view('santri.topups.index', compact('topups'));
    }

    public function waliTransactions(Request $request)
    {
        $user = Auth::user();
        $santris = $user->santris ?? collect();
        $santriIds = $santris->pluck('id');

        $query = Transaction::whereIn('santri_id', $santriIds)
            ->with(['items.product', 'santri.user'])  // Eager load items and product for efficiency
            ->latest();

        // Apply filters
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        if ($request->has('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        $transactions = $query->paginate(10);  // Changed to paginate for pagination support

        return view('wali.transactions', compact('transactions', 'santris'));
    }

    public function waliTopups(Request $request)
    {
        $user = Auth::user();
        $santris = $user->santris ?? collect();
        $santriIds = $santris->pluck('id');

        $query = Topup::whereIn('santri_id', $santriIds)
            ->with(['santri.user'])  // Eager load santri and user
            ->latest();

        // Apply filter by source if provided
        if (request()->has('source') && in_array(request()->input('source'), ['admin', 'wali'])) {
            $query->where('source', request()->input('source'));
        }

        // Apply filter by method if provided
        if (request()->has('method') && in_array(request()->input('method'), ['cash', 'transfer', 'manual', 'lainnya'])) {
            $query->where('method', request()->input('method'));
        }

        // Apply filter by santri name if provided
        if (request()->has('santri_name')) {
            $query->whereHas('santri.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . request()->input('santri_name') . '%');
            });
        }

        // Apply filter by date range if provided
        if (request()->has('start_date') && request()->has('end_date')) {
            $query->whereBetween('created_at', [request()->input('start_date'), request()->input('end_date')]);
        }

        $topups = $query->paginate(10);

        return view('wali.topups', compact('topups', 'santris'));
    }
}
