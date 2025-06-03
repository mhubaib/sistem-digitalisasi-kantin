@extends('layouts.wali')

@section('title', 'Dashboard Wali Santri')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <!-- Header Section with Gradient -->
    <div class="relative mb-8">
        <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-800 rounded-2xl opacity-10"></div>
        <div class="relative bg-white/80 backdrop-blur-sm rounded-2xl p-8 border border-green-100 shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-green-700 to-green-900 bg-clip-text text-transparent">
                        Dashboard Wali Santri
                    </h1>
                    <p class="text-gray-600 mt-2">Selamat datang di panel monitoring santri Anda</p>
                </div>
                <div class="hidden md:flex items-center space-x-2 text-sm text-gray-500">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->format('d F Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <!-- Total Anak (Santri) Card -->
        <div class="group relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl opacity-90"></div>
            <div class="relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 border border-blue-100 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-users text-white text-lg"></i>
                            </div>
                            <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Santri</h3>
                        </div>
                        <p class="text-3xl font-bold text-gray-800">{{ $santris->count() }}</p>
                        <p class="text-sm text-blue-600 font-medium mt-1">Anak yang terdaftar</p>
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-400/20 to-blue-600/20 rounded-full -mr-10 -mt-10"></div>
            </div>
        </div>

        <!-- Total Saldo Card -->
        <div class="group relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-green-700 rounded-2xl opacity-90"></div>
            <div class="relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 border border-green-100 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-wallet text-white text-lg"></i>
                            </div>
                            <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Saldo</h3>
                        </div>
                        <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</p>
                        <p class="text-sm text-green-600 font-medium mt-1">Saldo keseluruhan</p>
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-400/20 to-green-600/20 rounded-full -mr-10 -mt-10"></div>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="group relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl opacity-90"></div>
            <div class="relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 border border-purple-100 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-chart-line text-white text-lg"></i>
                            </div>
                            <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Aktivitas</h3>
                        </div>
                        <p class="text-3xl font-bold text-gray-800">{{ $recentTransactions->count() }}</p>
                        <p class="text-sm text-purple-600 font-medium mt-1">Transaksi terbaru</p>
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-400/20 to-purple-600/20 rounded-full -mr-10 -mt-10"></div>
            </div>
        </div>
    </div>

    <!-- Data Santri Section -->
    <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-green-50 to-green-100 px-8 py-6 border-b border-green-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Data Santri Anda</h2>
                        <p class="text-sm text-gray-600">Informasi lengkap tentang santri yang Anda awasi</p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                        {{ $santris->count() }} Santri
                    </span>
                </div>
            </div>
        </div>
        
        <div class="p-8">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-2 font-semibold text-gray-700 uppercase tracking-wide text-sm">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user text-gray-400"></i>
                                    <span>Nama Santri</span>
                                </div>
                            </th>
                            <th class="text-left py-4 px-2 font-semibold text-gray-700 uppercase tracking-wide text-sm">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-id-card text-gray-400"></i>
                                    <span>Email</span>
                                </div>
                            </th>
                            <th class="text-left py-4 px-2 font-semibold text-gray-700 uppercase tracking-wide text-sm">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-coins text-gray-400"></i>
                                    <span>Saldo</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($santris as $santri)
                            <tr class="hover:bg-green-50/50 transition-colors duration-200">
                                <td class="py-4 px-2">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                            {{ strtoupper(substr($santri->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $santri->user->name }}</p>
                                            <p class="text-sm text-gray-500">Santri Aktif</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-2">
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-lg font-mono text-sm">
                                        {{ $santri->user->email ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-4 px-2">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-lg font-bold text-green-600">
                                            Rp {{ number_format($santri->saldo, 0, ',', '.') }}
                                        </span>
                                        @if($santri->saldo > 50000)
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Baik</span>
                                        @elseif($santri->saldo > 10000)
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">Cukup</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium">Rendah</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center">
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-users text-gray-400 text-xl"></i>
                                        </div>
                                        <p class="text-gray-500 font-medium">Belum ada data santri</p>
                                        <p class="text-sm text-gray-400">Data santri akan muncul setelah didaftarkan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Transaksi Terbaru Section -->
    <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-8 py-6 border-b border-blue-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-history text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Transaksi Terbaru</h2>
                        <p class="text-sm text-gray-600">Aktivitas pembelian santri dalam 30 hari terakhir</p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                        {{ $recentTransactions->count() }} Transaksi
                    </span>
                </div>
            </div>
        </div>
        
        <div class="p-8">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-2 font-semibold text-gray-700 uppercase tracking-wide text-sm">Santri</th>
                            <th class="text-left py-4 px-2 font-semibold text-gray-700 uppercase tracking-wide text-sm">Total</th>
                            <th class="text-left py-4 px-2 font-semibold text-gray-700 uppercase tracking-wide text-sm">Metode</th>
                            <th class="text-left py-4 px-2 font-semibold text-gray-700 uppercase tracking-wide text-sm">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($recentTransactions as $trx)
                            <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                                <td class="py-4 px-2">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                            {{ strtoupper(substr($trx->santri->user->name ?? 'N/A', 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $trx->santri->user->name ?? '-' }}</p>
                                            <p class="text-sm text-gray-500">ID: {{ $trx->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-2">
                                    <span class="text-lg font-bold text-green-600">
                                        Rp {{ number_format($trx->total, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="py-4 px-2">
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-lg text-sm font-medium capitalize">
                                        <i class="fas fa-credit-card mr-1"></i>
                                        {{ $trx->payment_type }}
                                    </span>
                                </td>
                                <td class="py-4 px-2">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-800">{{ $trx->created_at->format('d M Y') }}</span>
                                        <span class="text-sm text-gray-500">{{ $trx->created_at->format('H:i') }} WIB</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center">
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-shopping-cart text-gray-400 text-xl"></i>
                                        </div>
                                        <p class="text-gray-500 font-medium">Belum ada transaksi</p>
                                        <p class="text-sm text-gray-400">Transaksi santri akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
/* Additional custom styles for premium look */
.stat-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Smooth animations */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slide-in-up {
    animation: slideInUp 0.6s ease-out;
}

/* Glass morphism effect */
.glass-morphism {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.18);
}

/* Custom scrollbar for tables */
.overflow-x-auto::-webkit-scrollbar {
    height: 6px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endsection