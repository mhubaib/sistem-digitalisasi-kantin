@extends('layouts.wali')

@section('title', 'Dashboard Wali Santri')

@section('content')
<div class="max-w-7xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Dashboard Wali Santri</h1>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Anak (Santri) -->
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-sm text-gray-500">Total Anak (Santri)</p>
            <p class="text-2xl font-semibold text-blue-600">{{ $santris->count() }}</p>
        </div>
        <!-- Total Saldo Anak -->
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-sm text-gray-500">Total Saldo Anak</p>
            <p class="text-2xl font-semibold text-green-600">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Daftar Anak (Santri) -->
    <div class="mt-10 bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-bold mb-4">Data Anak Anda</h2>
        <table class="min-w-full text-sm">
            <thead>
                <tr>
                    <th class="text-left py-2">Nama</th>
                    <th class="text-left py-2">NIS</th>
                    <th class="text-left py-2">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($santris as $santri)
                    <tr class="border-t">
                        <td class="py-2">{{ $santri->user->name }}</td>
                        <td class="py-2">{{ $santri->nis ?? '-' }}</td>
                        <td class="py-2">Rp {{ number_format($santri->saldo, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-4 text-center text-gray-500">Belum ada data santri</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Transaksi Terbaru Anak -->
    <div class="mt-10 bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-bold mb-4">Transaksi Terbaru Anak</h2>
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