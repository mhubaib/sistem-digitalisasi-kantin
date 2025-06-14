@extends('layouts.admin')

@section('title', 'Top-up Baru')

@section('content')
    <div class="container px-6 mx-auto max-w-6xl">
        <!-- Enhanced Breadcrumb -->
        <nav class="flex items-center text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
            <a href="{{ route('admin.dashboard') }}"
                class="hover:text-indigo-600 flex items-center transition-all duration-300 hover:scale-105 group">
                <i class="fas fa-home mr-2 text-xs group-hover:text-indigo-600"></i> Dashboard
            </a>
            <span class="mx-3 text-gray-300">•</span>
            <a href="{{ route('admin.topup.index') }}"
                class="hover:text-indigo-600 transition-all duration-300 hover:scale-105">Manajemen Top-up</a>
            <span class="mx-3 text-gray-300">•</span>
            <span class="text-gray-700 font-semibold">Top-up Baru</span>
        </nav>

        <!-- Main Card with Premium Design -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
            <!-- Header Section with Gradient -->
            <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Top-up Saldo Santri</h1>
                        <p class="text-indigo-100 text-lg">Kelola saldo dengan mudah dan aman</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-wallet text-3xl text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8 md:p-10">
                <!-- Success/Error Messages with Enhanced Design -->
                @if (session('success'))
                    <div
                        class="mb-8 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6 shadow-sm">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div>
                                <h4 class="text-green-800 font-semibold mb-1">Berhasil!</h4>
                                <p class="text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div
                        class="mb-8 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl p-6 shadow-sm">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-4 mt-0.5">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-red-800 font-semibold mb-2">Terjadi Kesalahan</h4>
                                <ul class="space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-red-700 flex items-center">
                                            <i class="fas fa-circle text-xs mr-2 text-red-400"></i>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.topup.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Enhanced Form Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Santri Selection with Premium Style -->
                            <div class="form-group">
                                <label for="santri_id" class="block text-sm font-semibold text-gray-800 mb-3">
                                    <i class="fas fa-user-graduate text-indigo-600 mr-2"></i>
                                    Pilih Santri
                                </label>
                                <div class="relative">
                                    <input type="text" id="santri_search" placeholder="Cari santri..."
                                        class="block w-full pl-4 pr-12 py-4 text-base border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 rounded-xl shadow-sm transition-all duration-300 bg-gray-50 focus:bg-white group-hover:border-gray-300">
                                    <input type="hidden" id="santri_id" name="santri_id">
                                    <div id="santri_dropdown"
                                        class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg mt-1 max-h-60 overflow-y-auto shadow-lg"
                                        style="display: none;">
                                        @foreach ($santris as $santri)
                                            <div class="p-3 text-sm text-gray-700 cursor-pointer hover:bg-gray-100 transition-colors"
                                                data-value="{{ $santri->id }}"
                                                data-label="{{ $santri->user->name }} - Saldo: Rp {{ number_format($santri->saldo, 0, ',', '.') }}"
                                                onclick="selectSantri('{{ $santri->id }}', '{{ $santri->user->name }} - Saldo: Rp {{ number_format($santri->saldo, 0, ',', '.') }}')">
                                                {{ $santri->user->name }} - Saldo: Rp
                                                {{ number_format($santri->saldo, 0, ',', '.') }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Amount Input with Advanced Styling -->
                            <div class="form-group">
                                <label for="amount" class="block text-sm font-semibold text-gray-800 mb-3">
                                    <i class="fas fa-money-bill-wave text-green-600 mr-2"></i>
                                    Jumlah Top-up
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-600 font-semibold text-lg">Rp</span>
                                    </div>
                                    <input type="text" name="amount" id="amount" required
                                        class="block w-full pl-12 pr-16 py-4 text-lg font-semibold border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 rounded-xl transition-all duration-300 bg-gray-50 focus:bg-white text-gray-800"
                                        placeholder="0" value="{{ old('amount') }}">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm">.00</span>
                                    </div>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-600">
                                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                    <span>Minimal top-up <strong class="text-blue-600">Rp 1.000</strong></span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Payment Methods -->
                        <div class="space-y-6">
                            <div class="form-group">
                                <label class="block text-sm font-semibold text-gray-800 mb-4">
                                    <i class="fas fa-credit-card text-purple-600 mr-2"></i>
                                    Metode Pembayaran
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Cash Option -->
                                    <label class="relative group cursor-pointer">
                                        <input type="radio" name="method" value="cash" class="peer sr-only"
                                            {{ old('method') == 'cash' ? 'checked' : '' }}>
                                        <div
                                            class="w-full p-6 bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl transition-all duration-300 ease-in-out
                                            peer-checked:border-green-500 peer-checked:ring-4 peer-checked:ring-green-100 peer-checked:shadow-lg 
                                            hover:border-green-300 hover:shadow-md transform hover:scale-105 peer-checked:scale-105">
                                            <div class="text-center">
                                                <div
                                                    class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <i class="fas fa-money-bill-wave text-xl text-green-600"></i>
                                                </div>
                                                <h4 class="font-bold text-gray-800 mb-1">Tunai</h4>
                                                <p class="text-sm text-gray-600">Pembayaran cash</p>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Transfer Option -->
                                    <label class="relative group cursor-pointer">
                                        <input type="radio" name="method" value="transfer" class="peer sr-only"
                                            {{ old('method') == 'transfer' ? 'checked' : '' }}>
                                        <div
                                            class="w-full p-6 bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl transition-all duration-300 ease-in-out
                                            peer-checked:border-blue-500 peer-checked:ring-4 peer-checked:ring-blue-100 peer-checked:shadow-lg 
                                            hover:border-blue-300 hover:shadow-md transform hover:scale-105 peer-checked:scale-105">
                                            <div class="text-center">
                                                <div
                                                    class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <i class="fas fa-university text-xl text-blue-600"></i>
                                                </div>
                                                <h4 class="font-bold text-gray-800 mb-1">Transfer Bank</h4>
                                                <p class="text-sm text-gray-600">Transfer via bank</p>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Manual Option -->
                                    <label class="relative group cursor-pointer">
                                        <input type="radio" name="method" value="manual" class="peer sr-only"
                                            {{ old('method') == 'manual' ? 'checked' : '' }}>
                                        <div
                                            class="w-full p-6 bg-gradient-to-br from-yellow-50 to-amber-50 border-2 border-yellow-200 rounded-xl transition-all duration-300 ease-in-out
                                            peer-checked:border-yellow-500 peer-checked:ring-4 peer-checked:ring-yellow-100 peer-checked:shadow-lg 
                                            hover:border-yellow-300 hover:shadow-md transform hover:scale-105 peer-checked:scale-105">
                                            <div class="text-center">
                                                <div
                                                    class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <i class="fas fa-hand-holding-usd text-xl text-yellow-600"></i>
                                                </div>
                                                <h4 class="font-bold text-gray-800 mb-1">Manual</h4>
                                                <p class="text-sm text-gray-600">Input manual</p>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Other Option -->
                                    <label class="relative group cursor-pointer">
                                        <input type="radio" name="method" value="lainnya" class="peer sr-only"
                                            {{ old('method') == 'lainnya' ? 'checked' : '' }}>
                                        <div
                                            class="w-full p-6 bg-gradient-to-br from-gray-50 to-slate-50 border-2 border-gray-200 rounded-xl transition-all duration-300 ease-in-out
                                            peer-checked:border-gray-500 peer-checked:ring-4 peer-checked:ring-gray-100 peer-checked:shadow-lg 
                                            hover:border-gray-300 hover:shadow-md transform hover:scale-105 peer-checked:scale-105">
                                            <div class="text-center">
                                                <div
                                                    class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <i class="fas fa-ellipsis-h text-xl text-gray-600"></i>
                                                </div>
                                                <h4 class="font-bold text-gray-800 mb-1">Lainnya</h4>
                                                <p class="text-sm text-gray-600">Metode lain</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Action Buttons -->
                    <div
                        class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-8 border-t border-gray-100">
                        <div class="text-sm text-gray-600 flex items-center">
                            <i class="fas fa-shield-alt text-green-500 mr-2"></i>
                            <span>Transaksi aman dan terenkripsi</span>
                        </div>

                        <div class="flex gap-4">
                            <a href="{{ route('admin.topup.index') }}"
                                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-semibold border border-gray-200 hover:border-gray-300">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </a>

                            <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-lg hover:shadow-xl transform transition-all duration-300 hover:scale-105 font-semibold group">
                                <i
                                    class="fas fa-paper-plane mr-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                                Proses Top-up
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Additional Info Section -->
                <div class="mt-10 pt-8 border-t border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-clock text-blue-600"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-1">Proses Cepat</h4>
                            <p class="text-sm text-gray-600">Saldo akan masuk dalam hitungan detik</p>
                        </div>

                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-shield-check text-green-600"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-1">100% Aman</h4>
                            <p class="text-sm text-gray-600">Transaksi dilindungi sistem keamanan terbaik</p>
                        </div>

                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-headset text-purple-600"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-1">Support 24/7</h4>
                            <p class="text-sm text-gray-600">Tim support siap membantu kapan saja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Wait for DOM to be fully loaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeDropdown);
        } else {
            initializeDropdown();
        }

        function initializeDropdown() {

            // Get elements
            const santriSearch = document.getElementById('santri_search');
            const santriDropdown = document.getElementById('santri_dropdown');
            const santriId = document.getElementById('santri_id');
            const form = document.querySelector('form'); // Declare form here once

            // Check if elements exist
            if (!santriSearch) {
                return;
            }
            if (!santriDropdown) {
                return;
            }
            if (!santriId) {
                return;
            }

            // Show/hide functions
            function showDropdown() {
                // console.log('Showing dropdown');
                santriDropdown.style.display = 'block';
            }

            function hideDropdown() {
                // console.log('Hiding dropdown');
                santriDropdown.style.display = 'none';
            }

            // Global select function
            window.selectSantri = function(id, label) {
                // console.log('Selecting santri:', id, label);
                santriId.value = id;
                santriSearch.value = label;
                hideDropdown();
            }

            // Add event listeners
            santriSearch.addEventListener('input', function() {
                // console.log('Search input changed');
                const searchTerm = this.value.toLowerCase();
                const items = santriDropdown.querySelectorAll('div[data-value]');

                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });

                showDropdown();
            });

            santriSearch.addEventListener('focus', function() {
                // console.log('Search input focused');
                showDropdown();
            });

            document.addEventListener('click', function(e) {
                if (!santriDropdown.contains(e.target) && e.target !== santriSearch) {
                    hideDropdown();
                }
            });

            // Initial state
            hideDropdown();
            // console.log('Dropdown initialization complete');
        }

        // Enhanced amount input formatting
        const amountInput = document.getElementById('amount');

        // Format input on typing
        amountInput.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, "");
            if (value === "") {
                this.value = "";
                return;
            }

            // Format with thousand separator
            let formatted = parseInt(value).toLocaleString('id-ID');
            this.value = formatted;

            // Add visual feedback for minimum amount
            if (parseInt(value) < 1000) {
                this.classList.add('border-red-300', 'focus:border-red-500', 'focus:ring-red-100');
                this.classList.remove('border-gray-200', 'focus:border-green-500',
                    'focus:ring-green-100');
            } else {
                this.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-100');
                this.classList.add('border-gray-200', 'focus:border-green-500', 'focus:ring-green-100');
            }
        });

        // Remove formatting before form submission
        const form = amountInput.closest('form');
        form.addEventListener('submit', function(e) {
            const rawValue = amountInput.value.replace(/\D/g, "");
            amountInput.value = rawValue;
        });

        // Add smooth animation for payment method selection
        const paymentOptions = document.querySelectorAll('input[name="method"]');
        paymentOptions.forEach(option => {
            option.addEventListener('change', function() {
                // Remove animation from all options
                paymentOptions.forEach(opt => {
                    const label = opt.closest('label');
                    label.querySelector('div').classList.remove('animate-pulse');
                });

                // Add animation to selected option
                if (this.checked) {
                    const label = this.closest('label');
                    label.querySelector('div').classList.add('animate-pulse');
                    setTimeout(() => {
                        label.querySelector('div').classList.remove('animate-pulse');
                    }, 1000);
                }
            });
        });

        // Add loading state to submit button
        const submitButton = document.querySelector('button[type="submit"]');

        form.addEventListener('submit', function(e) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            submitButton.classList.add('opacity-75', 'cursor-not-allowed');
        });
    </script>
@endsection
