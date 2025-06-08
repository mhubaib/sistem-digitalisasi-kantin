@extends('layouts.santri')

@section('title', 'Dashboard Santri')

@section('content')
    <div class="max-w-7xl mx-auto py-8">
        <!-- Header Section with Gradient -->
        <div class="relative mb-8">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl opacity-10"></div>
            <div class="relative bg-white/80 backdrop-blur-sm rounded-2xl p-8 border border-blue-100 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h1
                            class="text-3xl font-bold bg-gradient-to-r from-blue-700 to-blue-900 bg-clip-text text-transparent">
                            Selamat Datang, {{ Auth::user()->name }}
                        </h1>
                        <p class="text-gray-600 mt-2">Berikut adalah ringkasan aktivitas Anda</p>
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
            <!-- Saldo Card -->
            <div class="group relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-green-700 rounded-2xl opacity-90"></div>
                <div
                    class="relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 border border-green-100 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-wallet text-white text-lg"></i>
                                </div>
                                <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Saldo Anda</h3>
                            </div>
                            <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($santri->saldo, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-green-600 font-medium mt-1">Saldo terkini</p>
                        </div>
                    </div>
                    <div
                        class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-400/20 to-green-600/20 rounded-full -mr-10 -mt-10">
                    </div>
                </div>
            </div>

            <!-- Total Transaksi Card -->
            <div class="group relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl opacity-90"></div>
                <div
                    class="relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 border border-blue-100 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-shopping-cart text-white text-lg"></i>
                                </div>
                                <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Transaksi</h3>
                            </div>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalTransactions }}</p>
                            <p class="text-sm text-blue-600 font-medium mt-1">Transaksi keseluruhan</p>
                        </div>
                    </div>
                    <div
                        class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-400/20 to-blue-600/20 rounded-full -mr-10 -mt-10">
                    </div>
                </div>
            </div>

            <!-- Status Card -->
            <div class="group relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl opacity-90"></div>
                <div
                    class="relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 border border-purple-100 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-user-check text-white text-lg"></i>
                                </div>
                                <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Status Akun</h3>
                            </div>
                            <p class="text-3xl font-bold text-gray-800">Aktif</p>
                            <p class="text-sm text-purple-600 font-medium mt-1">Akun terverifikasi</p>
                        </div>
                    </div>
                    <div
                        class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-400/20 to-purple-600/20 rounded-full -mr-10 -mt-10">
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaksi Terakhir Section -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-8 py-6 border-b border-blue-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-history text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Riwayat Transaksi Terakhir</h2>
                            <p class="text-sm text-gray-600">Aktivitas pembelian Anda dalam 30 hari terakhir</p>
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
                                <th class="text-left py-4 px-2 font-semibold text-gray-700 uppercase tracking-wide text-sm">
                                    Total</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-700 uppercase tracking-wide text-sm">
                                    Metode</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-700 uppercase tracking-wide text-sm">
                                    Tanggal</th>
                                <th class="text-left py-4 px-2 font-semibold text-gray-700 uppercase tracking-wide text-sm">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($recentTransactions as $trx)
                                <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                                    <td class="py-4 px-2">
                                        <span class="text-lg font-bold text-green-600">
                                            Rp {{ number_format($trx->total, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span
                                            class="bg-gray-100 text-gray-700 px-3 py-1 rounded-lg text-sm font-medium capitalize">
                                            <i class="fas fa-credit-card mr-1"></i>
                                            {{ $trx->payment_type }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-2">
                                        <div class="flex flex-col">
                                            <span
                                                class="font-medium text-gray-800">{{ $trx->created_at->format('d M Y') }}</span>
                                            <span class="text-sm text-gray-500">{{ $trx->created_at->format('H:i') }}
                                                WIB</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span
                                            class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800 font-medium">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Sukses
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center">
                                        <div class="flex flex-col items-center space-y-3">
                                            <div
                                                class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-shopping-cart text-gray-400 text-xl"></i>
                                            </div>
                                            <p class="text-gray-500 font-medium">Belum ada transaksi</p>
                                            <p class="text-sm text-gray-400">Transaksi Anda akan muncul di sini</p>
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
