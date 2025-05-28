@extends('layouts.santri')

@section('title', 'Dashboard Santri')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6 md:mb-8">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}</h1>
        <p class="text-gray-600">Berikut adalah ringkasan aktivitas Anda</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
        <!-- Saldo Card -->
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Saldo Anda</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800 mt-1">
                        Rp {{ number_format($santri->saldo, 0, ',', '.') }}
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-wallet text-green-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Jumlah Transaksi Card -->
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Transaksi</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800 mt-1">
                        {{ $totalTransactions }} Transaksi
                    </p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-shopping-cart text-blue-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-purple-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Status Akun</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800 mt-1">
                        Aktif
                    </p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-user-check text-purple-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Terakhir -->
    <div class="bg-white shadow-sm rounded-xl p-4 md:p-6">
        <div class="flex justify-between items-center mb-4 md:mb-6">
            <h2 class="text-base md:text-lg font-bold text-gray-800">Riwayat Transaksi Terakhir</h2>
            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat Semua</a>
        </div>
        
        <div class="overflow-x-auto -mx-4 md:mx-0">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-gray-500 border-b">
                        <th class="text-left py-3 px-4 font-medium">Total</th>
                        <th class="text-left py-3 px-4 font-medium">Metode</th>
                        <th class="text-left py-3 px-4 font-medium">Tanggal</th>
                        <th class="text-left py-3 px-4 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentTransactions as $trx)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 font-medium">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 capitalize">{{ $trx->payment_type }}</td>
                        <td class="py-3 px-4">{{ $trx->created_at->format('d M Y H:i') }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Sukses</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-500">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection