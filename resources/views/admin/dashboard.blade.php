@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Total Santri -->
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-sm text-gray-500">Total Santri</p>
            <p class="text-2xl font-semibold text-blue-600">{{ $totalSantri }}</p>
        </div>

        <!-- Total Saldo Santri -->
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-sm text-gray-500">Total Saldo Santri</p>
            <p class="text-2xl font-semibold text-green-600">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</p>
        </div>

        <!-- Pendapatan Hari Ini -->
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-sm text-gray-500">Pendapatan Hari Ini</p>
            <p class="text-2xl font-semibold text-indigo-600">Rp {{ number_format($todayIncome, 0, ',', '.') }}</p>
        </div>

    </div>

    <!-- Transaksi Terbaru -->
    <div class="mt-10 bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-bold mb-4">Transaksi Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr>
                        <th class="text-left py-2">Santri</th>
                        <th class="text-left py-2">Total</th>
                        <th class="text-left py-2">Metode</th>
                        <th class="text-left py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentTransactions as $trx)
                    <tr class="border-t">
                        <td class="py-2">{{ $trx->santri->user->name ?? '-' }}</td>
                        <td class="py-2">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                        <td class="py-2 capitalize">{{ $trx->payment_type }}</td>
                        <td class="py-2">{{ $trx->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
