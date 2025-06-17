@extends('layouts.admin')

@section('title', 'Riwayat Wallet Santri')

@section('content')
    <div class="max-w-screen mx-auto px-6 lg:px-8">
        <!-- Breadcrumb dengan styling baru -->
        <nav class="flex items-center text-sm text-gray-400 mb-8" aria-label="Breadcrumb">
            <a href="{{ route('admin.dashboard') }}"
                class="hover:text-blue-500 flex items-center transition-colors duration-200">
                <i class="fas fa-home mr-2 text-xs"></i> Dashboard
            </a>
            <span class="mx-3 text-gray-300">•</span>
            <span class="text-gray-600 font-medium">Riwayat Wallet Santri</span>
        </nav>

        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-light text-gray-800 mb-2">Riwayat Wallet Santri</h1>
            <p class="text-gray-500 text-sm">Kelola dan pantau semua transaksi wallet santri</p>
        </div>

        <!-- Filter Section dengan Glass Morphism -->
        <div class="bg-white/60 backdrop-blur-sm border border-gray-200/50 rounded-2xl shadow-sm p-8 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-medium text-gray-700">Filter & Pencarian</h2>
                <div class="w-12 h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full"></div>
            </div>

            <form action="{{ route('admin.wallet_histories.index') }}" method="GET" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Filter: Santri -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-600">Santri</label>
                        <div class="relative">
                            <select name="santri_id"
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 appearance-none">
                                <option value="">Semua Santri</option>
                                @foreach ($santris as $santri)
                                    <option value="{{ $santri->id }}"
                                        {{ request('santri_id') == $santri->id ? 'selected' : '' }}>
                                        {{ $santri->name }}
                                    </option>
                                @endforeach
                            </select>
                            <i
                                class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- Filter: Tipe Transaksi -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-600">Tipe Transaksi</label>
                        <div class="relative">
                            <select name="type"
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 appearance-none">
                                <option value="">Semua Tipe</option>
                                <option value="topup" {{ request('type') == 'topup' ? 'selected' : '' }}>Topup</option>
                                <option value="purchase" {{ request('type') == 'purchase' ? 'selected' : '' }}>Pembelian
                                </option>
                            </select>
                            <i
                                class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- Filter: Tanggal Mulai -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-600">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200">
                    </div>

                    <!-- Filter: Tanggal Akhir -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-600">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div class="flex gap-3">
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                            <i class="fas fa-search text-sm"></i>
                            Filter
                        </button>
                        @if (request('santri_id') || request('type') || request('start_date') || request('end_date'))
                            <a href="{{ route('admin.wallet_histories.index') }}"
                                class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-all duration-200 flex items-center gap-2">
                                <i class="fas fa-undo text-sm"></i>
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 border border-blue-200/50 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 text-sm font-medium mb-1">Total Transaksi</p>
                        <p class="text-2xl font-light text-blue-800">{{ $walletHistories->total() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-receipt text-blue-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-50 to-red-100/50 border border-red-200/50 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-600 text-sm font-medium mb-1">Total Nominal</p>
                        <p class="text-2xl font-light text-red-800">Rp
                            {{ number_format($walletHistories->sum('amount'), 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-line text-red-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100/50 border border-green-200/50 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-800 text-sm font-medium mb-1">Total Topup</p>
                        <p class="text-2xl font-light text-green-600">Rp
                            {{ number_format($walletHistories->where('type', 'topup')->sum('amount'), 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-line text-green-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/50 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-800">Data Riwayat Wallet</h3>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-layer-group text-xs"></i>
                            {{ $walletHistories->total() }} total transaksi
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Santri
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Metode</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Deskripsi</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dibuat Oleh</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($walletHistories as $index => $history)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div
                                        class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 font-medium text-xs">
                                        {{ $walletHistories->firstItem() + $index }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $history->santri->user->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($history->type == 'topup')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-plus-circle mr-1"></i>Topup
                                        </span>
                                    @elseif($history->type == 'purchase')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-shopping-cart mr-1"></i>Pembelian
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-900">{{ $history->method ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($history->type == 'purchase')
                                        <span class="text-lg font-semibold text-red-600">Rp
                                            {{ number_format($history->amount, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-lg font-semibold text-green-600">Rp
                                            {{ number_format($history->amount, 0, ',', '.') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-900 max-w-xs truncate block"
                                        title="{{ $history->description ?? '-' }}">
                                        {{ $history->description ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-medium text-sm">
                                            {{ substr($history->createdBy->name ?? 'N', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $history->createdBy->name }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $history->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $history->created_at->format('H:i') }} WIB</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-inbox text-gray-400 text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada riwayat</h3>
                                        <p class="text-gray-500 text-sm">Belum ada data riwayat wallet yang tersedia saat
                                            ini.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($walletHistories->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                    {{ $walletHistories->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Custom styles untuk halaman riwayat wallet */
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.1);
        }

        /* Custom select dropdown */
        select:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Custom table hover */
        tbody tr:hover {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.02) 0%, rgba(147, 51, 234, 0.02) 100%);
        }

        /* Custom pagination styling */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .pagination a {
            color: #6b7280;
            text-decoration: none;
        }

        .pagination a:hover {
            background-color: #f3f4f6;
            color: #374151;
        }

        .pagination .active span {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: white;
        }

        /* Smooth animations */
        * {
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        /* Glass morphism effect */
        .backdrop-blur-sm {
            backdrop-filter: blur(8px);
        }
    </style>
@endsection
