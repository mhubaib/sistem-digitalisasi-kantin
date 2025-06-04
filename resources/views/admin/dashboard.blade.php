@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <!-- Sophisticated Header -->
            <div class="mb-12">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-extralight text-slate-900 mb-2 tracking-tight">
                            Dashboard
                        </h1>
                        <div class="flex items-center space-x-2 text-slate-600">
                            <span class="text-sm font-medium">Selamat datang kembali,</span>
                            <span class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                    <div class="hidden lg:flex items-center space-x-4 text-xs text-slate-500 font-mono">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                            <span>Sistem Aktif</span>
                        </div>
                        <div class="w-px h-4 bg-slate-300"></div>
                        <span>{{ now()->format('d M Y, H:i') }}</span>
                    </div>
                </div>
                <div class="w-20 h-px bg-gradient-to-r from-slate-800 to-transparent mt-6"></div>
            </div>

            <!-- Executive Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Total Santri -->
                <a href="{{ route('admin.santri.index') }}" class="group block">
                    <div
                        class="bg-white/70 backdrop-blur-xl border border-white/20 rounded-3xl p-8 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-slate-300/50 transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <div class="relative">
                            <div class="flex items-start justify-between mb-6">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/25">
                                    <i class="fas fa-users text-white text-lg"></i>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-light text-slate-900 tracking-tight">
                                        {{ number_format($totalSantri) }}</div>
                                    <div class="text-xs font-medium text-slate-500 uppercase tracking-widest mt-1">Total
                                        Santri</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="text-xs text-slate-600">Kelola data santri</div>
                                <i
                                    class="fas fa-arrow-right text-slate-400 group-hover:text-blue-500 group-hover:translate-x-1 transition-all duration-300"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Total Saldo -->
                <div
                    class="bg-white/70 backdrop-blur-xl border border-white/20 rounded-3xl p-8 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-slate-300/50 transition-all duration-500 hover:-translate-y-2 relative overflow-hidden group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative">
                        <div class="flex items-start justify-between mb-6">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/25">
                                <i class="fas fa-wallet text-white text-lg"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-light text-slate-900 tracking-tight">Rp
                                    {{ number_format($totalSaldo, 0, ',', '.') }}</div>
                                <div class="text-xs font-medium text-slate-500 uppercase tracking-widest mt-1">Total Saldo
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-slate-600">Akumulasi saldo santri</div>
                    </div>
                </div>

                <!-- Pendapatan Hari Ini -->
                <div
                    class="bg-white/70 backdrop-blur-xl border border-white/20 rounded-3xl p-8 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-slate-300/50 transition-all duration-500 hover:-translate-y-2 relative overflow-hidden group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-violet-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative">
                        <div class="flex items-start justify-between mb-6">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-violet-500 to-violet-600 rounded-2xl flex items-center justify-center shadow-lg shadow-violet-500/25">
                                <i class="fas fa-chart-line text-white text-lg"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-light text-slate-900 tracking-tight">Rp
                                    {{ number_format($todayIncome, 0, ',', '.') }}</div>
                                <div class="text-xs font-medium text-slate-500 uppercase tracking-widest mt-1">Hari Ini
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-slate-600">Pendapatan harian</div>
                    </div>
                </div>
            </div>

            <!-- Transactions Section -->
            <div
                class="bg-white/60 backdrop-blur-xl border border-white/30 rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden">
                <!-- Section Header -->
                <div class="px-10 py-8 border-b border-slate-100/60">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-light text-slate-900 mb-1">Aktivitas Transaksi</h2>
                            <p class="text-sm text-slate-500">Riwayat pembayaran terkini</p>
                        </div>
                    </div>
                </div>

                <!-- Table - Fixed Version -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th
                                    class="text-left py-6 px-6 text-xs font-semibold text-slate-600 uppercase tracking-wider min-w-[200px]">
                                    <i class="fas fa-users mr-2 text-black"></i> Customer
                                </th>
                                <th
                                    class="text-left py-6 px-6 text-xs font-semibold text-slate-600 uppercase tracking-wider min-w-[140px]">
                                    <i class="fas fa-dollar-sign mr-2 text-black"></i> Total
                                </th>
                                <th
                                    class="text-left py-6 px-6 text-xs font-semibold text-slate-600 uppercase tracking-wider min-w-[120px]">
                                    <i class="fas fa-credit-card mr-2 text-black"></i> Metode
                                </th>
                                <th
                                    class="text-left py-6 px-6 text-xs font-semibold text-slate-600 uppercase tracking-wider min-w-[140px]">
                                    <i class="fas fa-calendar mr-2 text-black"></i> Tanggal
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/60">
                            @forelse ($recentTransactions as $index => $trx)
                                <tr
                                    class="hover:bg-slate-200 transition-all duration-200 hover:border-blue-500 hover:border-l-4">
                                    <td class="py-6 px-6 min-w-[200px]">
                                        <div class="flex items-center space-x-4">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-slate-500 to-slate-800 rounded-xl flex items-center justify-center text-white text-sm font-medium shadow-md">
                                                {{ substr($trx->santri->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-slate-900">
                                                    {{ optional(optional($trx->santri)->user)->name ?? '-' }}
                                                </div>
                                                <div class="text-xs text-slate-500">Transaction
                                                    #{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-6 px-6 min-w-[140px]">
                                        <div class="font-semibold text-slate-900 text-lg">Rp
                                            {{ number_format($trx->total, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="py-6 px-6 min-w-[120px]">
                                        <div
                                            class="inline-flex items-center space-x-2 px-4 py-2 rounded-full text-xs font-medium border
                                            {{ $trx->payment_type == 'saldo'
                                                ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                                : 'bg-blue-50 text-blue-700 border-blue-200' }}">
                                            <div
                                                class="w-2 h-2 rounded-full 
                                                {{ $trx->payment_type == 'saldo' ? 'bg-emerald-400' : 'bg-blue-400' }}">
                                            </div>
                                            <span class="uppercase tracking-wide">{{ $trx->payment_type }}</span>
                                        </div>
                                    </td>
                                    <td class="py-6 px-6 min-w-[140px]">
                                        <div class="text-sm font-medium text-slate-900">
                                            {{ $trx->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-slate-500 font-mono">{{ $trx->created_at->format('H:i') }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-20 text-center">
                                        <div class="flex flex-col items-center space-y-4">
                                            <div
                                                class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-receipt text-slate-400 text-2xl"></i>
                                            </div>
                                            <div class="text-center">
                                                <h3 class="text-lg font-medium text-slate-900 mb-1">Belum Ada Transaksi</h3>
                                                <p class="text-sm text-slate-500">Transaksi akan ditampilkan di sini ketika
                                                    ada aktivitas</p>
                                            </div>
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
        /* Executive Glass Effect */
        .backdrop-blur-xl {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        /* Sophisticated Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-4px);
            }
        }

        .group:hover .fas.fa-arrow-right {
            animation: float 2s ease-in-out infinite;
        }

        /* Premium Gradients */
        .bg-gradient-to-br {
            background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom Font Weights */
        .font-extralight {
            font-weight: 200;
        }

        /* Professional Transitions */
        * {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Executive Shadow */
        .shadow-xl {
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        /* Status Indicator Animation */
        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse-dot 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Refined Typography */
        .tracking-tight {
            letter-spacing: -0.025em;
        }

        .tracking-widest {
            letter-spacing: 0.1em;
        }

        /* Table Fixes */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            text-align: left;
            vertical-align: middle;
        }
    </style>
@endsection
