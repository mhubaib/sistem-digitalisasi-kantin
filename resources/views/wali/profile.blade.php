@extends('layouts.wali')

@section('title', 'Profil Wali')

@section('content')
    <!-- Header Section with Gradient Background -->
    <div class="relative mb-8">
        <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-green-600 rounded-2xl p-8 shadow-xl">
            <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
                <!-- Avatar Section -->
                <div class="relative">
                    <div
                        class="w-24 h-24 md:w-32 md:h-32 bg-white rounded-full flex items-center justify-center shadow-lg ring-4 ring-white ring-opacity-20">
                        <i class="fas fa-user-tie text-4xl md:text-5xl text-emerald-600"></i>
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-white flex items-center justify-center">
                        <i class="fas fa-check text-white text-xs"></i>
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $user->name }}</h1>
                    <div
                        class="flex flex-col md:flex-row items-center md:items-start space-y-2 md:space-y-0 md:space-x-6 text-white/90">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-envelope text-sm"></i>
                            <span class="text-sm">{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-shield-alt text-sm"></i>
                            <span class="text-sm font-medium px-3 py-1 bg-white/20 rounded-full">Wali Santri</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg shadow-sm animate-slide-in mb-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        <script>
            setTimeout(function() {
                var flash = document.querySelector('.bg-green-50');
                if (flash) {
                    flash.classList.add('animate-slide-out');
                    setTimeout(function() {
                        flash.style.display = 'none';
                    }, 500); // waktu harus sama dengan durasi animasi slide-out
                }
            }, 3000);
        </script>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg shadow-sm animate-slide-in mb-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        <script>
            setTimeout(function() {
                var flash = document.querySelector('.bg-red-50');
                if (flash) {
                    flash.classList.add('animate-slide-out');
                    setTimeout(function() {
                        flash.style.display = 'none';
                    }, 500); // waktu harus sama dengan durasi animasi slide-out
                }
            }, 3000);
        </script>
    @endif

    <!-- Breadcrumb Navigation -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('wali.dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-emerald-600">
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

    <!-- Main Content Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Form Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-edit text-emerald-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Informasi Pribadi</h2>
                    </div>
                </div>

                <form id="profile-form" action="{{ route('wali.profile.update') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Wali -->
                        <div class="group">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user text-emerald-500 mr-2"></i>Nama Wali
                            </label>
                            <div class="relative">
                                <input type="text" id="name" name="name" value="{{ $user->name }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white hover:border-emerald-300"
                                    required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fas fa-edit text-gray-400 group-hover:text-emerald-500 transition-colors"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Email Wali -->
                        <div class="group">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope text-gray-400 mr-2"></i>Email Wali
                            </label>
                            <div class="relative">
                                <input type="email" id="email" value="{{ $user->email }}"
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
                    </div>

                    <div
                        class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 mt-8 pt-6 border-t border-gray-200">
                        <button type="button" id="update-password-btn"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white font-medium rounded-xl hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-key mr-2"></i>Ubah Password
                        </button>
                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-medium rounded-xl hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Santri Information Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-graduate text-indigo-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Informasi Santri</h2>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Santri Avatar -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-user text-2xl text-indigo-600"></i>
                        </div>
                    </div>

                    <!-- Santri List -->
                    <div class="space-y-4">
                        @forelse($santris as $santri)
                            <div class="bg-indigo-50 rounded-xl p-4">
                                <!-- Nama Santri -->
                                <div class="group mb-3">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-user text-indigo-500 mr-2"></i>Nama Santri
                                    </label>
                                    <div class="relative">
                                        <input type="text" value="{{ $santri->user->name }}"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-indigo-50 text-indigo-700 font-medium cursor-not-allowed"
                                            readonly>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Santri -->
                                <div class="group">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-envelope text-indigo-500 mr-2"></i>Email Santri
                                    </label>
                                    <div class="relative">
                                        <input type="email" value="{{ $santri->user->email }}"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-indigo-50 text-indigo-700 cursor-not-allowed"
                                            readonly>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Button -->
                                <div class="pt-4 mt-4 border-t border-gray-200">
                                    <a href="mailto:{{ $santri->user->email }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                        <i class="fas fa-envelope mr-2"></i>Hubungi Santri
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-user-graduate text-gray-400 text-4xl mb-2"></i>
                                <p class="text-gray-500">Belum ada santri yang terdaftar</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Update Modal -->
    <div id="password-modal"
        class="fixed inset-0 bg-opacity-50 backdrop-blur-xl flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4 rounded-t-2xl">
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

            <!-- Flash Messages -->
            <div id="password-modal-errors" class="px-6 pt-4">
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg shadow-sm animate-slide-in">
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

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg shadow-sm animate-slide-in">
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
            </div>

            <!-- Modal Body -->
            <form id="password-form" action="{{ route('wali.profile.update-password') }}" method="POST"
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
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                                required>
                            <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 password-toggle"
                                data-target="current_password">
                                <i class="fas fa-eye text-gray-400 hover:text-emerald-500 transition-colors"></i>
                            </button>
                        </div>
                        @if ($errors->has('current_password'))
                            <div class="mt-2 text-xs text-red-500">
                                {{ $errors->first('current_password') }}
                            </div>
                        @endif
                    </div>

                    <!-- New Password -->
                    <div class="group">
                        <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-key text-emerald-500 mr-2"></i>Password Baru
                        </label>
                        <div class="relative">
                            <input type="password" id="new_password" name="new_password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                                required>
                            <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 password-toggle"
                                data-target="new_password">
                                <i class="fas fa-eye text-gray-400 hover:text-emerald-500 transition-colors"></i>
                            </button>
                        </div>
                        <div class="mt-2">
                            <div class="text-xs text-gray-500">
                                Password harus minimal 8 karakter
                            </div>
                        </div>
                        @if ($errors->has('new_password'))
                            <div class="mt-2 text-xs text-red-500">
                                {{ $errors->first('new_password') }}
                            </div>
                        @endif
                    </div>

                    <!-- Confirm New Password -->
                    <div class="group">
                        <label for="new_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>Konfirmasi Password Baru
                        </label>
                        <div class="relative">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                                required>
                            <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 password-toggle"
                                data-target="new_password_confirmation">
                                <i class="fas fa-eye text-gray-400 hover:text-emerald-500 transition-colors"></i>
                            </button>
                        </div>
                        @if ($errors->has('new_password_confirmation'))
                            <div class="mt-2 text-xs text-red-500">
                                {{ $errors->first('new_password_confirmation') }}
                            </div>
                        @endif
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
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-medium rounded-xl hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 shadow-lg hover:shadow-xl">
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

        .group:hover .group-hover\:text-emerald-500 {
            color: #10b981;
        }

        /* Custom focus styles */
        input:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
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
            const passwordForm = document.getElementById('password-form');
            const passwordModalErrors = document.getElementById('password-modal-errors');

            // Function to create dismissible flash message
            function createFlashMessage(type, message, container) {
                const flashDiv = document.createElement('div');
                flashDiv.className =
                    `relative ${type === 'success' ? 'bg-green-50 border-green-400' : 'bg-red-50 border-red-400'} border-l-4 p-4 rounded-r-lg shadow-sm animate-slide-in`;

                flashDiv.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas ${type === 'success' ? 'fa-check-circle text-green-400' : 'fa-exclamation-triangle text-red-400'}"></i>
                            </div>
                            <div class="ml-3">
                                <p class="${type === 'success' ? 'text-green-700' : 'text-red-700'} font-medium">${message}</p>
                            </div>
                        </div>
                        <button class="flash-message-close ml-4 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;

                // Add close functionality
                const closeBtn = flashDiv.querySelector('.flash-message-close');
                closeBtn.addEventListener('click', function() {
                    flashDiv.classList.remove('animate-slide-in');
                    flashDiv.classList.add('animate-slide-out');
                    setTimeout(() => {
                        flashDiv.remove();
                    }, 500);
                });

                container.appendChild(flashDiv);
            }

            // Show modal
            updatePasswordBtn.addEventListener('click', function() {
                passwordModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                // Clear previous error messages
                passwordModalErrors.innerHTML = '';
            });

            // Hide modal function
            function hideModal() {
                passwordModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                // Clear form
                passwordForm.reset();
                // Clear error messages
                passwordModalErrors.innerHTML = '';
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

            // Handle form submission
            passwordForm.addEventListener('submit', function(event) {
                // Prevent default form submission
                event.preventDefault();

                // Create FormData object
                const formData = new FormData(passwordForm);

                // Send AJAX request
                fetch(passwordForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Clear previous error messages
                        passwordModalErrors.innerHTML = '';

                        if (data.success) {
                            // Success: show success message and close modal
                            createFlashMessage('success', data.message, passwordModalErrors);

                            // Close modal after a short delay
                            setTimeout(hideModal, 2000);

                            // Create a success flash message outside the modal
                            const mainFlashContainer = document.querySelector(
                                '.bg-gradient-to-r.from-emerald-600');
                            if (mainFlashContainer) {
                                const successMessage = document.createElement('div');
                                successMessage.className =
                                    'bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg shadow-sm animate-slide-in mt-4';
                                successMessage.innerHTML = `
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check-circle text-green-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-green-700 font-medium">${data.message}</p>
                                        </div>
                                    </div>
                                    <button class="flash-message-close ml-4 text-gray-500 hover:text-gray-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            `;

                                // Add close functionality
                                const closeBtn = successMessage.querySelector('.flash-message-close');
                                closeBtn.addEventListener('click', function() {
                                    successMessage.classList.remove('animate-slide-in');
                                    successMessage.classList.add('animate-slide-out');
                                    setTimeout(() => {
                                        successMessage.remove();
                                    }, 500);
                                });

                                mainFlashContainer.insertAdjacentElement('afterend', successMessage);
                            }
                        } else {
                            // Errors: display error messages
                            const errorMessages = data.errors ?
                                Object.values(data.errors).flat().join('<br>') :
                                'Terjadi kesalahan saat mengubah password';

                            createFlashMessage('error', errorMessages, passwordModalErrors);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        createFlashMessage('error', 'Terjadi kesalahan. Silakan coba lagi.',
                            passwordModalErrors);
                    });
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
