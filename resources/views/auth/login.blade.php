<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Kantin PIT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        .card-shadow {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .input-focus:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-1px);
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

        .flash-message {
            animation: slideOut 0.5s ease-in-out forwards;
            animation-delay: 3s;
            overflow: hidden;
        }

        .flash-message>div {
            transition: all 0.5s ease-in-out;
        }
    </style>
</head>

<body class="min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-12 w-12 bg-white rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-utensils text-blue-600 text-xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-white">Kantin PIT</h2>
                <p class="mt-2 text-blue-100">Masuk ke akun Anda</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-xl card-shadow p-8">
                <!-- Alert Messages -->
                <div id="error-message"
                    class="flash-message hidden mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span id="error-text"></span>
                    </div>
                </div>

                <div id="success-message"
                    class="flash-message hidden mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span id="success-text"></span>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" required
                                class="input-focus block w-full pl-10 pr-3 py-3 border border-gray-300 
                                rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none transition-all"
                                placeholder="email@example.com">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" name="password" type="password" required
                                class="input-focus block w-full pl-10 pr-10 py-3 border border-gray-300 
                                rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none transition-all"
                                placeholder="Masukkan password">
                            <button type="button" onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <i id="password-toggle" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                                Ingat saya
                            </label>
                        </div>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-500">
                            Lupa password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="btn-primary w-full flex justify-center items-center py-3 px-4 
                        text-sm font-medium rounded-lg text-white shadow-sm">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk
                    </button>
                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Daftar sebagai santri
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-blue-100 text-sm">
                    &copy; <span id="current-year"></span> Kantin PIT. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Set current year
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('password-toggle');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Show message function
        function showMessage(type, message) {
            const errorDiv = document.getElementById('error-message');
            const successDiv = document.getElementById('success-message');
            const errorText = document.getElementById('error-text');
            const successText = document.getElementById('success-text');

            // Reset animation by removing and re-adding the class
            errorDiv.classList.remove('flash-message');
            successDiv.classList.remove('flash-message');
            void errorDiv.offsetWidth; // Trigger reflow
            void successDiv.offsetWidth; // Trigger reflow
            errorDiv.classList.add('flash-message');
            successDiv.classList.add('flash-message');

            errorDiv.classList.add('hidden');
            successDiv.classList.add('hidden');

            if (type === 'error') {
                errorText.textContent = message;
                errorDiv.classList.remove('hidden');
            } else if (type === 'success') {
                successText.textContent = message;
                successDiv.classList.remove('hidden');
            }
        }
    </script>
    @if (session('success'))
        <script>
            showMessage('success', '{{ session('success') }}');
        </script>
    @endif
    @if (session('warning'))
        <script>
            showMessage('error', '{{ session('warning') }}');
        </script>
    @endif
    @if (session('error'))
        <script>
            showMessage('error', '{{ session('error') }}');
        </script>
    @endif
</body>

</html>
