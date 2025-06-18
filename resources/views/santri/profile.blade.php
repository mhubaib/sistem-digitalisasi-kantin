@extends('layouts.santri')

@section('title', 'Profil Santri')

@section('content')
    <!-- Header Section with Gradient Background -->
    <div class="relative mb-8">
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 rounded-2xl p-8 shadow-xl">
            <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
                <!-- Avatar Section -->
                <div class="relative">
                    <div
                        class="w-24 h-24 md:w-32 md:h-32 bg-white rounded-full flex items-center justify-center shadow-lg ring-4 ring-white ring-opacity-20">
                        <i class="fas fa-user text-4xl md:text-5xl text-indigo-600"></i>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-white flex items-center justify-center">
                        <i class="fas fa-check text-white text-xs"></i>
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $santri->user->name }}</h1>
                    <div
                        class="flex flex-col md:flex-row items-center md:items-start space-y-2 md:space-y-0 md:space-x-6 text-white/90">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-envelope text-sm"></i>
                            <span class="text-sm">{{ $santri->user->email }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-shield-alt text-sm"></i>
                            <span
                                class="text-sm font-medium px-3 py-1 bg-white/20 rounded-full">{{ $santri->status }}</span>
                        </div>
                    </div>
                </div>

                <!-- Balance Card -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 min-w-[200px]">
                    <div class="text-center">
                        <p class="text-white/80 text-sm mb-1">Saldo Tersedia</p>
                        <p class="text-2xl font-bold text-white">Rp {{ number_format($santri->saldo, 0, ',', '.') }}</p>
                        <div class="flex items-center justify-center mt-2 text-green-300">
                            <i class="fas fa-wallet text-sm mr-1"></i>
                            <span class="text-xs">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Breadcrumb Navigation -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('santri.dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">Profil</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg shadow-sm animate-slide-in">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg shadow-sm animate-slide-in">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg shadow-sm animate-slide-in">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <ul class="text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Form Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-edit text-indigo-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Informasi Pribadi</h2>
                    </div>
                </div>

                <form id="profile-form" action="{{ route('santri.profile.update') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Santri -->
                        <div class="group">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user text-indigo-500 mr-2"></i>Nama Santri
                            </label>
                            <div class="relative">
                                <input type="text" id="name" name="name" value="{{ $santri->user->name }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white hover:border-indigo-300"
                                    required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fas fa-edit text-gray-400 group-hover:text-indigo-500 transition-colors"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Email Santri -->
                        <div class="group">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope text-gray-400 mr-2"></i>Email Santri
                            </label>
                            <div class="relative">
                                <input type="email" id="email" value="{{ $santri->user->email }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-500 cursor-not-allowed"
                                    readonly>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 flex items-center">
                                <i class="fas fa-info-circle mr-1"></i>
                                Email tidak bisa diubah. Hubungi admin jika ada masalah.
                            </p>
                        </div>

                        <!-- Status -->
                        <div class="group">
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-shield-alt text-green-500 mr-2"></i>Status
                            </label>
                            <div class="relative">
                                <input type="text" id="status" value="{{ $santri->status }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-green-50 text-green-700 font-medium cursor-not-allowed"
                                    readonly>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Saldo -->
                        <div class="group">
                            <label for="saldo" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-wallet text-blue-500 mr-2"></i>Saldo
                            </label>
                            <div class="relative">
                                <input type="text" id="saldo"
                                    value="Rp {{ number_format($santri->saldo, 0, ',', '.') }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-blue-50 text-blue-700 font-bold cursor-not-allowed"
                                    readonly>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fas fa-coins text-blue-500"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Kode RFID -->
                        <div class="md:col-span-2 group">
                            <label for="kode_rfid" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-credit-card text-purple-500 mr-2"></i>Kode RFID
                            </label>
                            <div class="relative">
                                <input type="text" id="kode_rfid"
                                    value="{{ $santri->rfid_code ? $santri->rfid_code : 'Tidak ada kode RFID' }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-purple-50 text-purple-700 font-mono cursor-not-allowed focus:outline-none"
                                    readonly tabindex="-1">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    @if ($santri->rfid_code)
                                        <div class="flex items-center space-x-2">
                                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                            <i class="fas fa-wifi text-purple-500"></i>
                                        </div>
                                    @else
                                        <i class="fas fa-exclamation-triangle text-orange-500"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 mt-8 pt-6 border-t border-gray-200">
                        <button type="button" id="update-password-btn"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white font-medium rounded-xl hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-key mr-2"></i>Ubah Password
                        </button>
                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Wali Information Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-emerald-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Informasi Wali</h2>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Wali Avatar -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-user-tie text-2xl text-emerald-600"></i>
                        </div>
                    </div>

                    <!-- Nama Wali -->
                    <div class="group">
                        <label for="wali_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user text-emerald-500 mr-2"></i>Nama Wali
                        </label>
                        <div class="relative">
                            <input type="text" id="wali_name" value="{{ $santri->wali->name }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-emerald-50 text-emerald-700 font-medium cursor-not-allowed"
                                readonly>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i>
                            Hanya bisa diubah oleh wali di halaman profil wali
                        </p>
                    </div>

                    <!-- Email Wali -->
                    <div class="group">
                        <label for="wali_email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope text-emerald-500 mr-2"></i>Email Wali
                        </label>
                        <div class="relative">
                            <input type="email" id="wali_email" value="{{ $santri->wali->email }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-emerald-50 text-emerald-700 cursor-not-allowed"
                                readonly>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i>
                            Hanya bisa diubah oleh wali di halaman profil wali
                        </p>
                    </div>

                    <!-- Contact Button -->
                    <div class="pt-4 border-t border-gray-200">
                        <a href="mailto:{{ $santri->wali->email }}"
                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-emerald-600 text-white font-medium rounded-xl hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200">
                            <i class="fas fa-envelope mr-2"></i>Hubungi Wali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Update Modal -->
    <div id="password-modal"
        class="fixed inset-0 bg-opacity-50 backdrop-blur-lg flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-key text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white">Ubah Password</h2>
                    </div>
                    <button type="button" id="close-modal-btn" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="password-form" action="{{ route('santri.profile.update-password') }}" method="POST"
                class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Current Password -->
                    <div class="group">
                        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock text-gray-500 mr-2"></i>Password Saat Ini
                        </label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                required>
                            <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 password-toggle"
                                data-target="current_password">
                                <i class="fas fa-eye text-gray-400 hover:text-indigo-500 transition-colors"></i>
                            </button>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="group">
                        <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-key text-indigo-500 mr-2"></i>Password Baru
                        </label>
                        <div class="relative">
                            <input type="password" id="new_password" name="new_password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                required>
                            <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 password-toggle"
                                data-target="new_password">
                                <i class="fas fa-eye text-gray-400 hover:text-indigo-500 transition-colors"></i>
                            </button>
                        </div>
                        <div class="mt-2">
                            <div class="text-xs text-gray-500">
                                Password harus minimal 8 karakter
                            </div>
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="group">
                        <label for="new_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>Konfirmasi Password Baru
                        </label>
                        <div class="relative">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                required>
                            <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 password-toggle"
                                data-target="new_password_confirmation">
                                <i class="fas fa-eye text-gray-400 hover:text-indigo-500 transition-colors"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div
                    class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <button type="button" id="cancel-password-btn"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gray-300 text-gray-800 font-medium rounded-xl hover:bg-gray-400 focus:outline-none transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-save mr-2"></i>Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slide-out {
            from {
                opacity: 1;
                transform: translateX(0);
                max-height: 100px;
                margin-bottom: 1.5rem;
            }

            to {
                opacity: 0;
                transform: translateX(100%);
                max-height: 0;
                margin-bottom: 0;
                padding: 0;
            }
        }

        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
        }

        .animate-slide-out {
            animation: slide-out 0.5s ease-in-out forwards;
            overflow: hidden;
        }

        .group:hover .group-hover\:text-indigo-500 {
            color: #6366f1;
        }

        /* Custom focus styles */
        input:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
        }

        /* Password strength indicator */
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        /* Hover effects for cards */
        .bg-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updatePasswordBtn = document.getElementById('update-password-btn');
            const passwordModal = document.getElementById('password-modal');
            const cancelPasswordBtn = document.getElementById('cancel-password-btn');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const passwordToggles = document.querySelectorAll('.password-toggle');

            // Show modal
            updatePasswordBtn.addEventListener('click', function() {
                passwordModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });

            // Hide modal function
            function hideModal() {
                passwordModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                // Clear form
                document.getElementById('password-form').reset();
            }

            // Hide modal events
            cancelPasswordBtn.addEventListener('click', hideModal);
            closeModalBtn.addEventListener('click', hideModal);

            // Close modal when clicking outside
            passwordModal.addEventListener('click', function(event) {
                if (event.target === passwordModal) {
                    hideModal();
                }
            });

            // Password visibility toggle
            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (targetInput.type === 'password') {
                        targetInput.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        targetInput.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Auto hide flash messages after 5 seconds
            setTimeout(function() {
                const flashMessages = document.querySelectorAll('[role="alert"], .animate-slide-in');
                flashMessages.forEach(function(message) {
                    message.classList.remove('animate-slide-in');
                    message.classList.add('animate-slide-out');
                    setTimeout(() => {
                        message.style.display = 'none';
                    }, 500);
                });
            }, 3000);

            // Add smooth scroll behavior for better UX
            document.documentElement.style.scrollBehavior = 'smooth';

            // Form validation enhancement
            const form = document.getElementById('profile-form');
            const nameInput = document.getElementById('name');

            nameInput.addEventListener('input', function() {
                if (this.value.length < 2) {
                    this.classList.add('border-red-300');
                    this.classList.remove('border-gray-300');
                } else {
                    this.classList.remove('border-red-300');
                    this.classList.add('border-gray-300');
                }
            });

            // Password matching validation
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('new_password_confirmation');

            function validatePasswords() {
                if (confirmPassword.value && newPassword.value !== confirmPassword.value) {
                    confirmPassword.classList.add('border-red-300');
                    confirmPassword.classList.remove('border-gray-300');
                } else {
                    confirmPassword.classList.remove('border-red-300');
                    confirmPassword.classList.add('border-gray-300');
                }
            }

            newPassword.addEventListener('input', validatePasswords);
            confirmPassword.addEventListener('input', validatePasswords);
        });
    </script>
@endsection
