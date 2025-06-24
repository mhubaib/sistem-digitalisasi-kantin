<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrasi Santri | Sistem Kantin PIT Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-image: linear-gradient(135deg, rgba(45, 55, 72, 0.05) 0%, rgba(45, 55, 72, 0.15) 100%);
        }

        /* Flash message animations */
        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateX(0);
                max-height: 100px;
                margin-bottom: 2rem;
            }

            100% {
                opacity: 1;
                transform: translateX(0);
                max-height: 100px;
                margin-bottom: 2rem;
            }
        }

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

        .register-container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            overflow: hidden;
        }

        .register-image {
            flex: 1;
            background: linear-gradient(135deg, #2c5282 0%, #3182ce 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            color: white;
            text-align: center;
        }

        .register-form {
            flex: 1;
            background-color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .register-logo {
            width: 80px;
            height: 80px;
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #3182ce;
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }

        .input-group .icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            transition: color 0.3s ease;
        }

        .input-group input:focus+.icon {
            color: #3182ce;
        }

        .register-btn {
            background: linear-gradient(135deg, #3182ce 0%, #2c5282 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(44, 82, 130, 0.3);
        }

        .login-link {
            color: #3182ce;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-link:hover {
            color: #2c5282;
            text-decoration: underline;
        }

        /* Flash message styles */
        .flash-message {
            width: 100%;
            padding: 15px;
            border-radius: 8px;
            display: none;
            align-items: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            position: relative;
            overflow: hidden;
        }

        .flash-message.show {
            display: flex;
            animation: slideIn 0.5s ease-in-out forwards;
        }

        .flash-message.hide {
            animation: slideOut 0.5s ease-in-out forwards;
            animation-delay: 2s;
        }

        .error-message {
            background-color: #fecaca;
            color: #7f1d1d;
            border-left: 4px solid #ef4444;
        }

        .success-message {
            background-color: #d1fae5;
            color: #064e3b;
            border-left: 4px solid #10b981;
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                max-width: 95%;
                margin: 1rem;
            }

            .register-image,
            .register-form {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <!-- Left Side - Image/Branding -->
        <div class="register-image">
            <div class="register-logo">
                <i class="fas fa-utensils text-3xl text-white"></i>
            </div>
            <h1 class="text-3xl font-bold mb-4">Sistem Kantin PIT Digital</h1>
            <p class="text-lg opacity-80 text-center">
                Selamat datang di platform manajemen kantin pondok yang modern dan terpercaya.
            </p>
        </div>

        <!-- Right Side - Register Form -->
        <div class="register-form">
            <h2 class="text-3xl font-bold mb-12 text-gray-800">Registrasi Santri</h2>

            <!-- Alert Messages -->
            @if (session('error'))
                <div class="flash-message error-message show">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="flash-message success-message show">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                <!-- Name Field -->
                <div class="input-group">
                    <input id="name" name="name" type="text" required placeholder="Nama Lengkap"
                        class="pl-12 @error('name') border-red-500 @enderror" value="{{ old('name') }}">
                    <i class="fas fa-user icon"></i>
                </div>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Email Field -->
                <div class="input-group">
                    <input id="email" name="email" type="email" required placeholder="Email Santri"
                        class="pl-12 @error('email') border-red-500 @enderror" value="{{ old('email') }}">
                    <i class="fas fa-envelope icon"></i>
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Wali Email Field -->
                <div class="input-group">
                    <input id="wali_email" name="wali_email" type="email" required placeholder="Email Wali Santri"
                        class="pl-12 @error('wali_email') border-red-500 @enderror" value="{{ old('wali_email') }}">
                    <i class="fas fa-users icon"></i>
                </div>
                @error('wali_email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Password Field -->
                <div class="input-group">
                    <input id="password" name="password" type="password" required placeholder="Password"
                        class="pl-12 pr-12 @error('password') border-red-500 @enderror">
                    <i class="fas fa-lock icon"></i>
                    <button type="button" onclick="togglePassword('password')"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i id="password-toggle" class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Password Confirmation Field -->
                <div class="input-group">
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        placeholder="Konfirmasi Password" class="pl-12 pr-12">
                    <i class="fas fa-lock icon"></i>
                    <button type="button" onclick="togglePassword('password_confirmation')"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i id="password_confirmation-toggle" class="fas fa-eye"></i>
                    </button>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="register-btn w-full mt-4">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar Sekarang
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('auth.login') }}" class="login-link">
                        Login di sini
                    </a>
                </p>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    &copy; <span id="current-year"></span> Sistem Kantin PIT Digital. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Set current year
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // Toggle password visibility
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(inputId + '-toggle');

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

        // Add dynamic flash message handling
        document.addEventListener('DOMContentLoaded', function() {
            const errorMessage = document.querySelector('.error-message');
            const successMessage = document.querySelector('.success-message');

            function handleFlashMessage(message) {
                if (message) {
                    setTimeout(() => {
                        message.classList.remove('show');
                        message.classList.add('hide');
                    }, 5000);
                }
            }

            handleFlashMessage(errorMessage);
            handleFlashMessage(successMessage);
        });
    </script>
</body>

</html>
