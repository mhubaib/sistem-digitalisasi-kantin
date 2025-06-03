@extends('layouts.admin')

@section('title', 'Riwayat Wallet Santri')

@section('content')
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl p-6 mb-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2 flex items-center">
                        <i class="fas fa-wallet mr-3"></i>
                        Riwayat Wallet Santri
                    </h1>
                    <p class="text-blue-100">Kelola dan pantau semua transaksi wallet santri</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 rounded-full p-4">
                        <i class="fas fa-chart-line text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center mb-6">
                <div class="bg-blue-500 rounded-full p-2 mr-3">
                    <i class="fas fa-filter text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Filter Pencarian</h2>
            </div>

            <form action="{{ route('admin.wallet_histories.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Filter: Santri -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-1 text-blue-500"></i>
                            Santri:
                        </label>
                        <select name="santri_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Santri</option>
                            @foreach ($santris as $santri)
                                <option value="{{ $santri->id }}" {{ request('santri_id') == $santri->id ? 'selected' : '' }}>
                                    {{ $santri->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter: Tipe Transaksi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tags mr-1 text-green-500"></i>
                            Tipe:
                        </label>
                        <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Semua Tipe</option>
                            <option value="topup" {{ request('type') == 'topup' ? 'selected' : '' }}>Topup</option>
                            <option value="purchase" {{ request('type') == 'purchase' ? 'selected' : '' }}>Pembelian</option>
                        </select>
                    </div>

                    <!-- Filter: Tanggal Mulai -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar-alt mr-1 text-purple-500"></i>
                            Dari Tanggal:
                        </label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <!-- Filter: Tanggal Akhir -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar-check mr-1 text-red-500"></i>
                            Sampai Tanggal:
                        </label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                        <i class="fas fa-search mr-2"></i>
                        Terapkan Filter
                    </button>
                    @if (request('santri_id') || request('type') || request('start_date') || request('end_date'))
                    <a href="{{ route('admin.wallet_histories.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors flex items-center">
                        <i class="fas fa-undo mr-2"></i>
                        Reset Filter
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gray-50 p-6 border-b">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-blue-600 rounded-full p-3 mr-3">
                            <i class="fas fa-list text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Daftar Riwayat Transaksi</h2>
                    </div>
                    <div class="bg-white rounded-lg px-4 py-2 shadow-sm">
                        <span class="text-sm text-gray-600">Total: {{ $walletHistories->total() }} transaksi</span>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                <i class="fas fa-user mr-2"></i>Santri
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                <i class="fas fa-tag mr-2"></i>Tipe
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold hidden sm:table-cell">
                                <i class="fas fa-credit-card mr-2"></i>Metode
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                <i class="fas fa-money-bill-wave mr-2"></i>Jumlah
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold hidden md:table-cell">
                                <i class="fas fa-info-circle mr-2"></i>Deskripsi
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold hidden lg:table-cell">
                                <i class="fas fa-user-cog mr-2"></i>Dibuat Oleh
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                <i class="fas fa-clock mr-2"></i>Tanggal
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($walletHistories as $index => $history)
                            <tr class="hover:bg-gray-100 hover:border-l-4 hover:border-blue-600 transition-all duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="bg-blue-500 rounded-full w-8 h-8 flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-white text-xs"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ $history->santri->user->name ?? '-' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($history->type == 'topup')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-plus-circle mr-1"></i>Topup
                                        </span>
                                    @elseif($history->type == 'purchase')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-shopping-cart mr-1"></i>Pembelian
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $history->type }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <span class="text-sm text-gray-900">{{ $history->method ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($history->type == 'purchase')
                                        <div class="flex items-center">
                                            {{-- <div class="bg-red-100 rounded-full p-1 mr-2">
                                                <i class="fas fa-minus text-red-600 text-xs"></i>
                                            </div> --}}
                                            <span class="text-red-600 font-semibold">
                                                Rp{{ number_format($history->amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="flex items-center">
                                            <div class="bg-green-100 rounded-full p-1 mr-2">
                                                <i class="fas fa-plus text-green-600 text-xs"></i>
                                            </div>
                                            <span class="text-green-600 font-semibold">
                                                Rp{{ number_format($history->amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <span class="text-sm text-gray-900 max-w-xs truncate block" title="{{ $history->description ?? '-' }}">
                                        {{ $history->description ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    <div class="flex items-center">
                                        <div class="bg-gray-500 rounded-full w-6 h-6 flex items-center justify-center mr-2">
                                            <i class="fas fa-user-tie text-white text-xs"></i>
                                        </div>
                                        <span class="text-sm text-gray-900">{{ $history->createdBy->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $history->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $history->created_at->format('H:i') }} WIB</div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="bg-gray-100 rounded-full p-6 mb-4">
                                            <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-600 mb-2">Tidak ada riwayat ditemukan</h3>
                                        <p class="text-gray-500">Belum ada transaksi yang sesuai dengan filter yang dipilih.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($walletHistories->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                            Menampilkan {{ $walletHistories->firstItem() }} - {{ $walletHistories->lastItem() }} dari {{ $walletHistories->total() }} hasil
                        </div>
                        <div>
                            {{ $walletHistories->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Focus styles for form elements */
        input:focus, select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Smooth transitions */
        button, a, tr {
            transition: all 0.2s ease;
        }

        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Responsive table */
        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
@endsection