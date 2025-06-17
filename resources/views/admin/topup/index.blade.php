@extends('layouts.admin')

@section('title', 'Manajemen Top-up')

@section('content')
    <div class="max-w-screen mx-auto px-4 lg:px-8">
        <!-- Breadcrumb dengan styling baru -->
        <nav class="flex items-center text-sm text-gray-400 mb-8" aria-label="Breadcrumb">
            <a href="{{ route('admin.dashboard') }}"
                class="hover:text-blue-500 flex items-center transition-colors duration-200">
                <i class="fas fa-home mr-2 text-xs"></i> Dashboard
            </a>
            <span class="mx-3 text-gray-300">•</span>
            <span class="text-gray-600 font-medium">Manajemen Top-up</span>
        </nav>

        <!-- Flash Message -->
        @if (session('success'))
            <div id="flash-message" class="mb-8 transform transition-all duration-500 ease-in-out translate-x-0 opacity-100">
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div id="flash-message"
                class="mb-8 transform transition-all duration-500 ease-in-out translate-x-0 opacity-100">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-light text-gray-800 mb-2">Manajemen Top-up</h1>
                    <p class="text-gray-500 text-sm">Kelola dan pantau semua transaksi top-up santri</p>
                </div>
                <a href="{{ route('admin.topup.create') }}"
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                    <i class="fas fa-plus text-sm"></i>
                    Top-up Baru
                </a>
            </div>
        </div>

        <!-- Filter Section dengan Glass Morphism -->
        <div class="bg-white/60 backdrop-blur-sm border border-gray-200/50 rounded-2xl shadow-sm p-8 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-medium text-gray-700">Filter & Pencarian</h2>
                <div class="w-12 h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full"></div>
            </div>

            <form action="{{ route('admin.topup.index') }}" method="GET" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
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
                                        {{ $santri->user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <i
                                class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- Filter: Metode -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-600">Metode</label>
                        <div class="relative">
                            <select name="method"
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 appearance-none">
                                <option value="">Semua Metode</option>
                                <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="transfer" {{ request('method') == 'transfer' ? 'selected' : '' }}>Transfer
                                </option>
                                <option value="manual" {{ request('method') == 'manual' ? 'selected' : '' }}>Manual
                                </option>
                                <option value="lainnya" {{ request('method') == 'lainnya' ? 'selected' : '' }}>Lainnya
                                </option>
                            </select>
                            <i
                                class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- Filter: Source -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-600">Sumber</label>
                        <div class="relative">
                            <select name="source"
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 appearance-none">
                                <option value="">Semua Sumber</option>
                                <option value="admin" {{ request('source') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="wali" {{ request('source') == 'wali' ? 'selected' : '' }}>Wali</option>
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
                        @if (request('santri_id') || request('method') || request('source') || request('start_date') || request('end_date'))
                            <a href="{{ route('admin.topup.index') }}"
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
                        <p class="text-blue-600 text-sm font-medium mb-1">Total Top-up Hari Ini</p>
                        <p class="text-2xl font-light text-blue-800">Rp {{ number_format($todayTopups ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-blue-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-50 to-red-100/50 border border-red-200/50 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-600 text-sm font-medium mb-1">Total Top-up Bulan Ini</p>
                        <p class="text-2xl font-light text-red-800">Rp {{ number_format($monthTopups ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-line text-red-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100/50 border border-green-200/50 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-800 text-sm font-medium mb-1">Total Transaksi</p>
                        <p class="text-2xl font-light text-green-600">{{ $totalTransactions ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-receipt text-green-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/50 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-800">Data Top-up</h3>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-layer-group text-xs"></i>
                            {{ $topups->total() }} total transaksi
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
                                Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Santri</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Metode</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($topups as $index => $topup)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div
                                        class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 font-medium text-xs">
                                        {{ $topups->firstItem() + $index }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $topup->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $topup->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-medium text-sm">
                                            {{ substr($topup->santri->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $topup->santri->user->name ?? 'Unknown' }}
                                            </p>
                                            <p class="text-xs text-gray-500">ID: {{ $topup->santri_id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-lg font-semibold text-green-600">Rp
                                        {{ number_format($topup->amount, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        {{ $topup->method == 'cash' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $topup->method == 'transfer' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $topup->method == 'manual' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $topup->method == 'lainnya' ? 'bg-gray-100 text-gray-800' : '' }}">
                                        {{ ucfirst($topup->method) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        Sukses
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-inbox text-gray-400 text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada top-up</h3>
                                        <p class="text-gray-500 text-sm">Belum ada data top-up yang tersedia saat ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($topups->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                    {{ $topups->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Custom styles untuk halaman top-up */
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.1);
        }

        /* Flash message animation */
        @keyframes slideOut {
            0% {
                transform: translateX(0);
                opacity: 1;
                max-height: 100px;
                margin-bottom: 2rem;
            }

            100% {
                transform: translateX(100%);
                opacity: 0;
                max-height: 0;
                margin-bottom: 0;
                padding: 0;
            }
        }

        #flash-message {
            animation: slideOut 0.5s ease-in-out forwards;
            animation-delay: 2s;
            overflow: hidden;
        }

        #flash-message>div {
            transition: all 0.5s ease-in-out;
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
