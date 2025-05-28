<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('admin.dashboard', [
            'totalSantri' => Santri::count(),
            'totalSaldo' => Santri::sum('saldo'),
            'todayIncome' => Transaction::whereDate('created_at', Carbon::today())->sum('total'),
            'recentTransactions' => Transaction::with('santri.user')
                ->latest()
                ->take(5)
                ->get(),
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
}
