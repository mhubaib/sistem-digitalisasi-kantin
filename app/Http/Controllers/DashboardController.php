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
use Illuminate\Support\Facades\Log;

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
        $user = Auth::user();
        $santri = Santri::with(['user', 'transactions', 'topups', 'walletHistories'])
            ->where('user_id', $user->id)
            ->first();

        return view('santri.dashboard', [
            'santri' => $santri,
            'totalTransactions' => $santri?->transactions()->count() ?? 0,
            'recentTransactions' => $santri?->transactions()
                ->with(['items.product'])
                ->latest()
                ->take(5)
                ->get() ?? collect(),
        ]);
    }

    public function wali()
    {
        $user = Auth::user();
        $santris = Santri::where('wali_id', $user->id)->get();
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
        $user = Auth::user();
        $santri = Santri::with(['transactions.items.product'])
            ->where('user_id', $user->id)
            ->first();

        if (!$santri) {
            return view('santri.transactions.index', [
                'transactions' => collect(),
                'totalSpending' => 0,
                'transactionItems' => collect(),
            ]);
        }

        // Get all transactions for the santri
        $query = Transaction::where('santri_id', $santri->id)->with(['items.product']);

        // Apply date filtering if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
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
        $user = Auth::user();
        $santri = Santri::with(['topups.createdBy'])
            ->where('user_id', $user->id)
            ->first();

        if (!$santri) {
            return view('santri.topups.index', [
                'topups' => collect(),
            ]);
        }

        $query = Topup::where('santri_id', $santri->id)->with('createdBy');

        // Apply date filtering if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        $topups = $query->latest()->get();

        return view('santri.topups.index', compact('topups'));
    }

    public function waliTransactions(Request $request)
    {
        $user = Auth::user();
        $santris = Santri::where('wali_id', $user->id)->get() ?? collect();
        $santriIds = $santris->pluck('id');

        $query = Transaction::whereIn('santri_id', $santriIds)
            ->with(['items.product', 'santri.user'])  // Eager load items and product for efficiency
            ->latest();

        // Apply filters
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        $transactions = $query->paginate(10);  // Changed to paginate for pagination support

        return view('wali.transactions', compact('transactions', 'santris'));
    }

    public function waliTopups(Request $request)
    {
        $user = Auth::user();
        $santris = Santri::where('wali_id', $user->id)->get() ?? collect();
        $santriIds = $santris->pluck('id');

        $query = Topup::whereIn('santri_id', $santriIds)
            ->with(['santri.user'])  // Eager load santri and user
            ->latest();

        // Apply filter by source if provided
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Apply filter by method if provided
        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        // Apply filter by santri name if provided
        if ($request->filled('santri_name')) {
            $query->whereHas('santri.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('santri_name') . '%');
            });
        }

        // Apply filter by date range if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $topups = $query->paginate(10);

        return view('wali.topups', compact('topups', 'santris'));
    }
}
