@extends('layouts.admin')

@section('title', 'Pengeluaran Kantin')

@section('content')
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 flex items-center">
                <i class="fas fa-home mr-1"></i> Dashboard
            </a>
            <span class="mx-2">/</span>
            <span class="text-gray-700 font-semibold">Pengeluaran Kantin</span>
        </nav>

        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl p-6 mb-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2 flex items-center">
                        <i class="fas fa-money-bill-wave mr-3"></i>
                        Pengeluaran Kantin
                    </h1>
                    <p class="text-blue-100">Kelola dan pantau semua pengeluaran kantin</p>
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

            <form action="{{ route('admin.expenses.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Filter: Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tags mr-1 text-blue-500"></i>
                            Kategori:
                        </label>
                        <select name="category"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            <option value="belanja" {{ request('category') == 'belanja' ? 'selected' : '' }}>Belanja
                            </option>
                            <option value="gaji" {{ request('category') == 'gaji' ? 'selected' : '' }}>Gaji</option>
                            <option value="utilities" {{ request('category') == 'utilities' ? 'selected' : '' }}>Utilities
                            </option>
                            <option value="lainnya" {{ request('category') == 'lainnya' ? 'selected' : '' }}>Lainnya
                            </option>
                        </select>
                    </div>

                    <!-- Filter: Metode Pembayaran -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-credit-card mr-1 text-green-500"></i>
                            Metode Pembayaran:
                        </label>
                        <select name="payment_method"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Semua Metode</option>
                            <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>
                                Transfer</option>
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
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                        <i class="fas fa-search mr-2"></i>
                        Terapkan Filter
                    </button>
                    @if (request('category') || request('payment_method') || request('start_date') || request('end_date'))
                        <a href="{{ route('admin.expenses.index') }}"
                            class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors flex items-center">
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
                        <h2 class="text-xl font-bold text-gray-800">Daftar Pengeluaran</h2>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="bg-white rounded-lg px-4 py-2 shadow-sm">
                            <span class="text-sm text-gray-600">Total: {{ $expenses->total() }} pengeluaran</span>
                        </div>
                        <a href="{{ route('admin.expenses.create') }}"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Pengeluaran
                        </a>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                <i class="fas fa-hashtag mr-2"></i>#
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                <i class="fas fa-tag mr-2"></i>Judul
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                <i class="fas fa-tags mr-2"></i>Kategori
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                <i class="fas fa-money-bill-wave mr-2"></i>Jumlah
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                <i class="fas fa-credit-card mr-2"></i>Metode
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                <i class="fas fa-calendar mr-2"></i>Tanggal
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                <i class="fas fa-user mr-2"></i>Dibuat Oleh
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                <i class="fas fa-cog mr-2"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($expenses as $index => $expense)
                            <tr
                                class="hover:bg-gray-100 hover:border-l-4 hover:border-blue-600 transition-all duration-200">
                                <td class="px-6 py-4">{{ $expenses->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $expense->title }}</div>
                                    @if ($expense->description)
                                        <div class="text-sm text-gray-500">{{ Str::limit($expense->description, 50) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        {{ $expense->category == 'belanja' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $expense->category == 'gaji' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $expense->category == 'utilities' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $expense->category == 'lainnya' ? 'bg-gray-100 text-gray-800' : '' }}">
                                        {{ ucfirst($expense->category) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-red-600 font-semibold">
                                        Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        {{ $expense->payment_method == 'cash' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($expense->payment_method) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $expense->expense_date->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="bg-gray-500 rounded-full w-6 h-6 flex items-center justify-center mr-2">
                                            <i class="fas fa-user-tie text-white text-xs"></i>
                                        </div>
                                        <span class="text-sm text-gray-900">{{ $expense->createdBy->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.expenses.edit', $expense) }}"
                                            class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengeluaran ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="bg-gray-100 rounded-full p-6 mb-4">
                                            <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-600 mb-2">Tidak ada pengeluaran ditemukan
                                        </h3>
                                        <p class="text-gray-500">Belum ada pengeluaran yang sesuai dengan filter yang
                                            dipilih.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td colspan="3" class="px-6 py-4 font-bold text-right">Total Pengeluaran:</td>
                            <td colspan="5" class="px-6 py-4 font-bold text-red-600">
                                Rp {{ number_format($totalExpenses, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Pagination -->
            @if ($expenses->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                            Menampilkan {{ $expenses->firstItem() }} - {{ $expenses->lastItem() }} dari
                            {{ $expenses->total() }} hasil
                        </div>
                        <div>
                            {{ $expenses->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Focus styles for form elements */
        input:focus,
        select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Smooth transitions */
        button,
        a,
        tr {
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
    </style>
@endsection
