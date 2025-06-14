@extends('layouts.santri')

@section('title', 'Riwayat Transaksi')

@section('content')
    <div class="container mx-auto">
        <!-- Header Section with Enhanced Design -->
        <div class="bg-gradient-to-r from-blue-700 to-emerald-700 rounded-2xl p-6 mb-8 text-white shadow-xl">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                <div>
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="bg-white/20 p-3 rounded-full">
                            <i class="fas fa-shopping-cart text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold">Riwayat Transaksi</h1>
                            <p class="text-green-100 mt-1">Pantau aktivitas belanja dan pembelian Anda</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                    <div class="text-center">
                        <p class="text-sm text-green-100 mb-1">Total Transaksi</p>
                        <p class="text-2xl font-bold">{{ $transactions->count() }}</p>
                        <p class="text-xs text-green-200">Aktivitas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Filter Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <div class="flex items-center space-x-3 mb-4">
                <div class="bg-green-100 p-2 rounded-lg">
                    <i class="fas fa-filter text-green-600"></i>
                </div>
                <h2 class="text-lg font-semibold text-gray-800">Filter Riwayat</h2>
            </div>

            <form method="GET" action="{{ route('santri.transactions.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <div class="relative">
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Tanggal Akhir</label>
                        <div class="relative">
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300">
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <button type="submit"
                            class="bg-gradient-to-r from-blue-700 to-emerald-600 hover:from-blue-700 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center space-x-2">
                            <i class="fas fa-search"></i>
                            <span>Filter</span>
                        </button>

                        @if (request()->has('start_date') || request()->has('end_date'))
                            <a href="{{ route('santri.transactions.index') }}"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition-all duration-300 flex items-center space-x-2 border border-gray-300">
                                <i class="fas fa-undo"></i>
                                <span>Reset</span>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Enhanced Total Spending Section -->
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl shadow-lg border border-amber-100 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="bg-amber-100 p-3 rounded-full">
                        <i class="fas fa-chart-line text-2xl text-amber-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Total Belanja</h2>
                        <p class="text-gray-600 text-sm">Akumulasi seluruh transaksi</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-amber-600">Rp {{ number_format($totalSpending, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500">{{ $transactions->count() }} transaksi</p>
                </div>
            </div>
        </div>

        <!-- Enhanced Transactions Grid -->
        @if ($transactions->isEmpty())
            <div class="bg-white rounded-2xl shadow-lg p-16 text-center border border-gray-100">
                <div class="max-w-md mx-auto">
                    <div class="bg-gray-100 w-24 h-24 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Transaksi</h3>
                    <p class="text-gray-500 mb-6">Anda belum memiliki riwayat transaksi. Mulai berbelanja untuk melihat
                        riwayat di sini.</p>
                    <a href="{{ route('santri.product.index') }}"
                        class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-700 to-emerald-600 hover:from-green-700 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Mulai Belanja</span>
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($transactions as $transaction)
                    <div
                        class="transaction-card bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 group">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="bg-green-100 p-2 rounded-lg group-hover:bg-green-200 transition-colors duration-300">
                                        <i class="fas fa-receipt text-green-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-sm">Transaksi
                                            #{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}</h3>
                                        <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Selesai
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4 space-y-4">
                            <!-- Product Name -->
                            <div class="text-center py-2">
                                <p class="text-sm text-gray-500 mb-1">Produk</p>
                                <p class="font-semibold text-gray-800 text-lg line-clamp-2">
                                    {{ $transaction->items->first()->product->name ?? 'Produk Tidak Diketahui' }}</p>
                            </div>

                            <!-- Amount Display -->
                            <div class="text-center py-4 bg-gray-50 rounded-xl">
                                <p class="text-sm text-gray-500 mb-1">Total Pembayaran</p>
                                <p class="text-2xl font-bold text-green-600">Rp
                                    {{ number_format($transaction->total, 0, ',', '.') }}</p>
                            </div>

                            <!-- Details -->
                            <div class="space-y-3 border-t border-gray-100 pt-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-calendar text-gray-400 text-sm"></i>
                                        <span class="text-sm text-gray-600">Tanggal</span>
                                    </div>
                                    <span
                                        class="text-sm font-medium text-gray-800">{{ $transaction->created_at->format('d/m/Y') }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-clock text-gray-400 text-sm"></i>
                                        <span class="text-sm text-gray-600">Waktu</span>
                                    </div>
                                    <span
                                        class="text-sm font-medium text-gray-800">{{ $transaction->created_at->format('H:i') }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-money-bill-wave text-gray-400 text-sm"></i>
                                        <span class="text-sm text-gray-600">Metode Pembayaran</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-800">
                                        @if ($transaction->payment_type === 'cash')
                                            <span
                                                class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Cash</span>
                                        @elseif($transaction->payment_type === 'saldo')
                                            <span
                                                class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Saldo</span>
                                        @else
                                            <span
                                                class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">{{ ucfirst($transaction->payment_method) }}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="bg-gray-50 px-4 py-3 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">ID: {{ $transaction->id }}</span>
                                <span class="text-xs text-gray-500">{{ $transaction->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Pagination (if applicable) -->
        @if (method_exists($transactions, 'links'))
            <div class="mt-8 flex justify-center">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

    <style>
        .transaction-card {
            transform: translateY(0);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .transaction-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .transaction-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10B981, #059669);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .transaction-card:hover::before {
            transform: scaleX(1);
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Enhanced input focus states */
        input[type="date"]:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        /* Smooth animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .transaction-card {
            animation: fadeInUp 0.5s ease-out;
        }

        .transaction-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .transaction-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .transaction-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .transaction-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .transaction-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .transaction-card:nth-child(6) {
            animation-delay: 0.6s;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .transaction-card:hover {
                transform: translateY(-4px);
            }
        }

        /* Loading state for buttons */
        .btn-loading {
            position: relative;
            color: transparent;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s ease infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
        // Add interactive enhancements
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading state to filter button
            const filterForm = document.querySelector('form');
            const filterButton = filterForm.querySelector('button[type="submit"]');

            filterForm.addEventListener('submit', function() {
                filterButton.classList.add('btn-loading');
                filterButton.disabled = true;
            });

            // Add smooth scroll to results
            const transactionCards = document.querySelectorAll('.transaction-card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            transactionCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                observer.observe(card);
            });
        });
    </script>
@endsection
