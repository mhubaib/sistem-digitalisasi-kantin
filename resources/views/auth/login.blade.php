<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Sistem Koperasi Digital</title>
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

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            overflow: hidden;
        }

        .login-image {
            flex: 1;
            background: linear-gradient(135deg, #2c5282 0%, #3182ce 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem;
            color: white;
            text-align: center;
        }

        .login-form {
            flex: 1;
            background-color: white;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-logo {
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

        .login-btn {
            background: linear-gradient(135deg, #3182ce 0%, #2c5282 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(44, 82, 130, 0.3);
        }

        .register-link {
            color: #3182ce;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .register-link:hover {
            color: #2c5282;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 95%;
                margin: 1rem;
            }

            .login-image,
            .login-form {
                padding: 2rem;
            }
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
        }

        .flash-message.show {
            display: flex;
            animation: slideIn 0.5s ease-in-out forwards;
        }

        .flash-message.hide {
            animation: slideOut 0.5s ease-in-out forwards;
            animation-delay: 2s;
            overflow: hidden;
        }

        #error-message {
            background-color: #fecaca;
            color: #7f1d1d;
            border-left: 4px solid #ef4444;
        }

        #success-message {
            background-color: #d1fae5;
            color: #064e3b;
            border-left: 4px solid #10b981;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Left Side - Image/Branding -->
        <div class="login-image">
            <div class="login-logo">
                <i class="fas fa-utensils text-3xl text-white"></i>
            </div>
            <h1 class="text-3xl font-bold mb-4">Sistem Kantin PIT Digital</h1>
            <p class="text-lg opacity-80 text-center">
                Selamat datang di platform manajemen kantin pondok yang modern dan terpercaya.
            </p>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-form">
            <h2 class="text-3xl font-bold mb-12 text-gray-800">Masuk ke Akun</h2>

            <!-- Alert Messages -->
            <div id="error-message" class="flash-message">
                <i class="fas fa-exclamation-circle mr-3"></i>
                <span id="error-text"></span>
            </div>

            <div id="success-message" class="flash-message">
                <i class="fas fa-check-circle mr-3"></i>
                <span id="success-text"></span>
            </div>

            <!-- Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <!-- Email Field -->
                <div class="input-group">
                    <input id="email" name="email" type="email" required placeholder="Email" class="pl-12">
                    <i class="fas fa-envelope icon"></i>
                </div>

                <!-- Password Field -->
                <div class="input-group">
                    <input id="password" name="password" type="password" required placeholder="Password"
                        class="pl-12 pr-12">
                    <i class="fas fa-lock icon"></i>
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i id="password-toggle" class="fas fa-eye"></i>
                    </button>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="login-btn w-full">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="register-link">
                        Daftar sebagai santri
                    </a>
                </p>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    &copy; <span id="current-year"></span> Sistem Koperasi Digital. All rights reserved.
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

            // Remove any existing classes
            errorDiv.classList.remove('show', 'hide');
            successDiv.classList.remove('show', 'hide');

            if (type === 'error') {
                errorText.textContent = message;
                errorDiv.classList.add('show');
            } else if (type === 'success') {
                successText.textContent = message;
                successDiv.classList.add('show');
            }

            // Auto-hide message after 5 seconds
            setTimeout(() => {
                if (type === 'error') {
                    errorDiv.classList.remove('show');
                    errorDiv.classList.add('hide');

                    // Remove hide class after animation completes
                    setTimeout(() => {
                        errorDiv.classList.remove('hide');
                    }, 300);
                } else if (type === 'success') {
                    successDiv.classList.remove('show');
                    successDiv.classList.add('hide');

                    // Remove hide class after animation completes
                    setTimeout(() => {
                        successDiv.classList.remove('hide');
                    }, 300);
                }
            }, 5000);
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
