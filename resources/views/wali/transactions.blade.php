@extends('layouts.wali')

@section('title', 'Riwayat Transaksi')

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
                            Riwayat Transaksi
                        </h1>
                        <p class="text-gray-600 mt-2">Kelola dan pantau semua transaksi pembelian santri Anda</p>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            {{ $transactions->total() ?? $transactions->count() }} Transaksi
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            {{ now()->format('d F Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Filter Section -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-green-50 to-green-100 px-8 py-6 border-b border-green-200">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-filter text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Filter & Pencarian</h2>
                        <p class="text-sm text-gray-600">Gunakan filter untuk menemukan data transaksi yang spesifik</p>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('wali.transactions') }}" class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Tanggal Mulai -->
                    <div class="space-y-2">
                        <label for="start_date" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">
                            <i class="fas fa-calendar-day text-orange-500 mr-2"></i>
                            Tanggal Mulai
                        </label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-white">
                    </div>

                    <!-- Tanggal Akhir -->
                    <div class="space-y-2">
                        <label for="end_date" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">
                            <i class="fas fa-calendar-check text-red-500 mr-2"></i>
                            Tanggal Akhir
                        </label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white">
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="space-y-2">
                        <label for="payment_type" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">
                            <i class="fas fa-credit-card text-green-500 mr-2"></i>
                            Metode Pembayaran
                        </label>
                        <select name="payment_type" id="payment_type"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white">
                            <option value="">Semua Metode</option>
                            <option value="cash" {{ request('payment_type') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="saldo" {{ request('payment_type') == 'saldo' ? 'selected' : '' }}>Saldo</option>
                        </select>
                    </div>

                    <!-- Nama Santri -->
                    <div class="space-y-2">
                        <label for="santri_name" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">
                            <i class="fas fa-graduation-cap text-purple-500 mr-2"></i>
                            Nama Santri
                        </label>
                        <select name="santri_name" id="santri_name"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white">
                            <option value="">Semua Santri</option>
                            @foreach ($santris as $santri)
                                <option value="{{ $santri->user->name }}"
                                    {{ request('santri_name') == $santri->user->name ? 'selected' : '' }}>
                                    {{ $santri->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center justify-between mt-8 pt-6 border-t border-gray-200">
                    <div class="flex flex-wrap gap-3">
                        <button type="submit"
                            class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 flex items-center space-x-2">
                            <i class="fas fa-search"></i>
                            <span>Terapkan Filter</span>
                        </button>

                        @if (request()->hasAny(['start_date', 'end_date', 'payment_type', 'santri_name']))
                            <a href="{{ route('wali.transactions') }}"
                                class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 flex items-center space-x-2">
                                <i class="fas fa-undo"></i>
                                <span>Reset Filter</span>
                            </a>
                        @endif
                    </div>

                    <div class="hidden md:flex items-center space-x-4 text-sm text-gray-500">
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-info-circle"></i>
                            <span>Menampilkan {{ $transactions->count() }} dari
                                {{ $transactions->total() ?? $transactions->count() }} data</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Transaction Cards Grid -->
        @if ($transactions->isEmpty())
            <div class="bg-white rounded-2xl shadow-lg p-16 text-center border border-gray-100">
                <div class="max-w-md mx-auto">
                    <div class="bg-gray-100 w-24 h-24 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Transaksi</h3>
                    <p class="text-gray-500 mb-6">Anak anda belum memiliki riwayat transaksi.</p>
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
                                        <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y') }}
                                        </p>
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

                            <!-- Amount Display -->
                            <div class="text-center py-4 bg-gray-50 rounded-xl">
                                <p class="text-sm text-gray-500 mb-1">Total Pembayaran</p>
                                <p class="text-2xl font-bold text-green-600">Rp
                                    {{ number_format($transaction->total, 0, ',', '.') }}</p>
                            </div>

                             <!-- Santri Info -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold text-xs">
                                        {{ strtoupper(substr($transaction->santri->user->name ?? 'N/A', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $transaction->santri->user->name ?? 'Tidak diketahui' }}</p>
                                        <p class="text-xs text-gray-500">Nama Santri</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Items Section -->
                            <div class="bg-yellow-50 rounded-lg p-3">
                                <h4 class="text-sm font-semibold text-yellow-800 mb-2 flex items-center">
                                    <i class="fas fa-box mr-2 text-yellow-600"></i>
                                    Item yang Dibeli
                                </h4>
                                <div class="space-y-2 max-h-32 overflow-y-auto">
                                    @forelse ($transaction->items as $item)
                                        <div class="bg-white rounded-md p-2 border border-yellow-200">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <p class="text-xs font-medium text-gray-800">
                                                        {{ $item->product->name ?? 'Produk tidak tersedia' }}</p>
                                                    <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-xs font-semibold text-green-600">
                                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-xs text-gray-500 italic">Tidak ada item</p>
                                    @endforelse
                                </div>
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
        <!-- Enhanced Pagination -->
        @if (method_exists($transactions, 'hasPages') && $transactions->hasPages())
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 border border-gray-100 shadow-lg">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} dari
                        {{ $transactions->total() ?? $transactions->count() }} hasil
                    </div>
                    <div class="pagination-wrapper">
                        {{ $transactions->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        /* Custom Pagination Styling */
        .pagination-wrapper .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 0.5rem;
        }

        .pagination-wrapper .page-item {
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .pagination-wrapper .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1rem;
            color: #6b7280;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            border-radius: 0.75rem;
            min-width: 2.5rem;
            height: 2.5rem;
        }

        .pagination-wrapper .page-item.active .page-link {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            border-color: #3b82f6;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .pagination-wrapper .page-link:hover {
            background: #e5e7eb;
            border-color: #d1d5db;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .pagination-wrapper .page-item.active .page-link:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
        }

        /* Form Enhancement */
        select:focus,
        input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        /* Card Enhancement */
        .transaction-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .transaction-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Animation */
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

        .animate-slide-in {
            animation: slideInUp 0.6s ease-out;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .grid.xl\:grid-cols-3 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }

            .lg\:grid-cols-4 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
        }

        /* Scrollbar styling for items section */
        .overflow-y-auto::-webkit-scrollbar {
            width: 4px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 2px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 2px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endsection
