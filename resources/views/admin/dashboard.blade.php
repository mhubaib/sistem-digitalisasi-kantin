@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6 md:mb-8">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}</h1>
        <p class="text-gray-600">Ringkasan sistem koperasi digital</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
        <!-- Total Santri Card -->
        <div class="stat-card bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Santri</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800 mt-1">
                        {{ $totalSantri }}
                    </p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-users text-blue-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Saldo Card -->
        <div class="stat-card bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Saldo Santri</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800 mt-1">
                        Rp {{ number_format($totalSaldo, 0, ',', '.') }}
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-wallet text-green-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pendapatan Hari Ini Card -->
        <div class="stat-card bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-indigo-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pendapatan Hari Ini</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800 mt-1">
                        Rp {{ number_format($todayIncome, 0, ',', '.') }}
                    </p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-lg">
                    <i class="fas fa-chart-line text-indigo-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-800">Transaksi Terbaru</h2>
            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
        </div>
        
        <div class="overflow-x-auto -mx-4 md:mx-0">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-gray-500 border-b">
                        <th class="text-left py-3 px-4 font-medium">Santri</th>
                        <th class="text-left py-3 px-4 font-medium">Total</th>
                        <th class="text-left py-3 px-4 font-medium">Metode</th>
                        <th class="text-left py-3 px-4 font-medium">Tanggal</th>
                        <th class="text-left py-3 px-4 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentTransactions as $trx)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $trx->santri->user->name ?? '-' }}</td>
                        <td class="py-3 px-4 font-medium">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 capitalize">
                            <span class="px-2 py-1 rounded-full text-xs {{ $trx->payment_type == 'saldo' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $trx->payment_type }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-gray-500">{{ $trx->created_at->format('d M Y H:i') }}</td>
                        <td class="py-3 px-4">
                            <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection