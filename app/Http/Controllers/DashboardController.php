<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') 
        {
            // data ringkasan untuk admin 
            $totalSantri = Santri::count();
            $totalTransactions = Transaction::count();
            $totalSaldoSantri = Santri::sum('saldo');
            $today = Carbon::today();
            $todayRevenue = Transaction::whereDate('created_at', $today)->sum('total');

            return view('dashboard.admin', compact('totalSantri', 'totalTransactions', 'totalSaldoSantri', 'todayRevenue'));
        }

        if ($user->role === 'wali')
        {
            // data ringkasan untuk wali santri
            $santris = $user->santris;
            $totalSaldo = $santris->sum('saldo');
            $recentTransactions = Transaction::whereIn('santri_id', $santris->pluck('id'))->orderBy('created_at', 'desc')->take(5)->get();

            return view('dashboard.wali', compact('santris', 'totalSaldo', 'recentTransactions'));
        }

        // role lain dilarang akses 
        abort(403, 'Akses ditolak');
            
    }
}
