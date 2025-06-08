@extends('layouts.admin')

@section('title', 'Edit Pengeluaran')

@section('content')
    <div class="container mx-auto px-6 lg:px-8">
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
            <span class="text-gray-600 font-medium">Edit Pengeluaran</span>
        </nav>

        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-light text-gray-800 mb-2">Edit Pengeluaran</h1>
            <p class="text-gray-500 text-sm">Ubah informasi pengeluaran kantin</p>
        </div>

        <!-- Form Section -->
        <div class="bg-white/60 backdrop-blur-sm border border-gray-200/50 rounded-2xl shadow-sm p-8">
            <form action="{{ route('admin.expenses.update', $expense) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Judul -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            <i class="fas fa-tag mr-1 text-blue-500"></i>
                            Judul Pengeluaran
                        </label>
                        <input type="text" name="title" value="{{ old('title', $expense->title) }}"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 @error('title') border-red-500 @enderror"
                            placeholder="Contoh: Belanja Bahan Makanan">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            <i class="fas fa-align-left mr-1 text-blue-500"></i>
                            Deskripsi
                        </label>
                        <textarea name="description" rows="3"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 @error('description') border-red-500 @enderror"
                            placeholder="Tambahkan deskripsi pengeluaran (opsional)">{{ old('description', $expense->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            <i class="fas fa-money-bill-wave mr-1 text-green-500"></i>
                            Jumlah
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number" name="amount" value="{{ old('amount', $expense->amount) }}"
                                class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all duration-200 @error('amount') border-red-500 @enderror"
                                placeholder="0">
                        </div>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            <i class="fas fa-tags mr-1 text-purple-500"></i>
                            Kategori
                        </label>
                        <div class="relative">
                            <select name="category"
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-200 appearance-none @error('category') border-red-500 @enderror">
                                <option value="">Pilih Kategori</option>
                                <option value="belanja"
                                    {{ old('category', $expense->category) == 'belanja' ? 'selected' : '' }}>Belanja
                                </option>
                                <option value="gaji"
                                    {{ old('category', $expense->category) == 'gaji' ? 'selected' : '' }}>Gaji</option>
                                <option value="utilities"
                                    {{ old('category', $expense->category) == 'utilities' ? 'selected' : '' }}>Utilities
                                </option>
                                <option value="lainnya"
                                    {{ old('category', $expense->category) == 'lainnya' ? 'selected' : '' }}>Lainnya
                                </option>
                            </select>
                            <i
                                class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                        </div>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Metode Pembayaran -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            <i class="fas fa-credit-card mr-1 text-blue-500"></i>
                            Metode Pembayaran
                        </label>
                        <div class="relative">
                            <select name="payment_method"
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 appearance-none @error('payment_method') border-red-500 @enderror">
                                <option value="">Pilih Metode</option>
                                <option value="cash"
                                    {{ old('payment_method', $expense->payment_method) == 'cash' ? 'selected' : '' }}>Cash
                                </option>
                                <option value="transfer"
                                    {{ old('payment_method', $expense->payment_method) == 'transfer' ? 'selected' : '' }}>
                                    Transfer</option>
                            </select>
                            <i
                                class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                        </div>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Kwitansi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            <i class="fas fa-receipt mr-1 text-gray-500"></i>
                            Nomor Kwitansi
                        </label>
                        <input type="text" name="receipt_number"
                            value="{{ old('receipt_number', $expense->receipt_number) }}"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-500/20 focus:border-gray-500 transition-all duration-200 @error('receipt_number') border-red-500 @enderror"
                            placeholder="Opsional">
                        @error('receipt_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Pengeluaran -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            <i class="fas fa-calendar mr-1 text-red-500"></i>
                            Tanggal Pengeluaran
                        </label>
                        <input type="date" name="expense_date"
                            value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-200 @error('expense_date') border-red-500 @enderror">
                        @error('expense_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex gap-4">
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                        <i class="fas fa-save text-sm"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.expenses.index') }}"
                        class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-all duration-200 flex items-center gap-2">
                        <i class="fas fa-times text-sm"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Custom styles untuk halaman edit pengeluaran */
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
