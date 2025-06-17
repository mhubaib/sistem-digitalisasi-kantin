@extends('layouts.admin')

@section('title', 'Tambah Pengeluaran')

@section('content')
    <div class="max-w-screen mx-auto px-4 lg:px-8">
        <!-- Breadcrumb dengan styling baru -->
        <nav class="flex items-center text-sm text-gray-400 mb-8" aria-label="Breadcrumb">
            <a href="{{ route('admin.dashboard') }}"
                class="hover:text-blue-500 flex items-center transition-colors duration-200">
                <i class="fas fa-home mr-2 text-xs"></i> Dashboard
            </a>
            <span class="mx-3 text-gray-300">•</span>
            <a href="{{ route('admin.expenses.index') }}"
                class="hover:text-blue-500 transition-colors duration-200">Pengeluaran Kantin</a>
            <span class="mx-3 text-gray-300">•</span>
            <span class="text-gray-600 font-medium">Tambah Pengeluaran</span>
        </nav>

        <!-- Header Section -->
        <div class="bg-gradient-to-br from-gray-800 to-gray-600 rounded-xl p-6 mb-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2 flex items-center">
                        <i class="fas fa-plus-circle mr-3"></i>
                        Tambah Pengeluaran
                    </h1>
                    <p class="text-blue-100">Tambahkan pengeluaran baru untuk kantin</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 rounded-full p-4">
                        <i class="fas fa-money-bill-wave text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <form action="{{ route('admin.expenses.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Judul -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag mr-1 text-blue-500"></i>
                            Judul Pengeluaran
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                            placeholder="Contoh: Belanja Bahan Makanan">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-align-left mr-1 text-blue-500"></i>
                            Deskripsi
                        </label>
                        <textarea name="description" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                            placeholder="Tambahkan deskripsi pengeluaran (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-money-bill-wave mr-1 text-green-500"></i>
                            Jumlah
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                            <input type="number" name="amount" value="{{ old('amount') }}"
                                class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('amount') border-red-500 @enderror"
                                placeholder="0">
                        </div>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tags mr-1 text-purple-500"></i>
                            Kategori
                        </label>
                        <select name="category"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('category') border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            <option value="belanja" {{ old('category') == 'belanja' ? 'selected' : '' }}>Belanja</option>
                            <option value="gaji" {{ old('category') == 'gaji' ? 'selected' : '' }}>Gaji</option>
                            <option value="utilities" {{ old('category') == 'utilities' ? 'selected' : '' }}>Utilities
                            </option>
                            <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Metode Pembayaran -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-credit-card mr-1 text-blue-500"></i>
                            Metode Pembayaran
                        </label>
                        <select name="payment_method"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('payment_method') border-red-500 @enderror">
                            <option value="">Pilih Metode</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer
                            </option>
                        </select>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Kwitansi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-receipt mr-1 text-gray-500"></i>
                            Nomor Kwitansi
                        </label>
                        <input type="text" name="receipt_number" value="{{ old('receipt_number') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 @error('receipt_number') border-red-500 @enderror"
                            placeholder="Opsional">
                        @error('receipt_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Pengeluaran -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-1 text-red-500"></i>
                            Tanggal Pengeluaran
                        </label>
                        <input type="date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('expense_date') border-red-500 @enderror">
                        @error('expense_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex gap-4">
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-br from-gray-800 to-gray-600 hover:bg-gradient-to-tl from-gray-800 to-gray-600 hover:translate-y-1 text-white rounded-lg transition-all flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Pengeluaran
                    </button>
                    <a href="{{ route('admin.expenses.index') }}"
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Focus styles for form elements */
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Smooth transitions */
        button,
        a {
            transition: all 0.2s ease;
        }
    </style>
@endsection
