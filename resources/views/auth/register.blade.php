<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Santri | Kantin PIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <h2 class="text-3xl font-bold text-white">Registrasi Santri</h2>
                <p class="mt-2 text-blue-100">Bergabung dengan Kantin PIT</p>
            </div>

            <!-- Register Card -->
            <div class="bg-white rounded-xl card-shadow p-8">
                <!-- Alert Messages -->
                <div id="error-message" class="hidden mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span id="error-text"></span>
                    </div>
                </div>

                <div id="success-message" class="hidden mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span id="success-text"></span>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input id="name" name="name" type="text" required 
                                class="input-focus block w-full pl-10 pr-3 py-3 border border-gray-300 
                                rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none transition-all" 
                                placeholder="Masukkan nama lengkap">
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Santri
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

                    <!-- Wali Email Field -->
                    <div>
                        <label for="wali_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Wali Santri
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-users text-gray-400"></i>
                            </div>
                            <input id="wali_email" name="wali_email" type="email" required 
                                class="input-focus block w-full pl-10 pr-3 py-3 border border-gray-300 
                                rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none transition-all" 
                                placeholder="wali@example.com">
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
                                placeholder="Minimal 6 karakter">
                            <button type="button" onclick="togglePassword('password')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <i id="password-toggle" class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-center">
                                <div class="flex-1 bg-gray-200 rounded-full h-2 mr-2">
                                    <div id="strength-bar" class="h-2 rounded-full transition-all duration-300" style="width: 0%;"></div>
                                </div>
                                <span id="strength-text" class="text-xs text-gray-500">Lemah</span>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                class="input-focus block w-full pl-10 pr-10 py-3 border border-gray-300 
                                rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none transition-all" 
                                placeholder="Ulangi password">
                            <button type="button" onclick="togglePassword('password_confirmation')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <i id="password_confirmation-toggle" class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="match-status" class="mt-2 text-xs hidden">
                            <div class="flex items-center">
                                <i id="match-icon" class="mr-1"></i>
                                <span id="match-text"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Terms Agreement -->
                    <div class="flex items-start">
                        <input id="terms" name="terms" type="checkbox" required
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1">
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            Saya setuju dengan <a href="#" class="text-blue-600 hover:text-blue-500">syarat dan ketentuan</a> yang berlaku
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                        class="btn-primary w-full flex justify-center items-center py-3 px-4 
                        text-sm font-medium rounded-lg text-white shadow-sm">
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar Sekarang
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun? 
                        <a href="{{ route('auth.login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Login di sini
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
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(fieldId + '-toggle');
            
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
        
        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            let feedback = 'Lemah';
            let color = '#ef4444';
            
            if (password.length >= 6) strength += 1;
            if (password.length >= 8) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            switch (strength) {
                case 0:
                case 1:
                    feedback = 'Lemah';
                    color = '#ef4444';
                    break;
                case 2:
                case 3:
                    feedback = 'Sedang';
                    color = '#f59e0b';
                    break;
                case 4:
                    feedback = 'Kuat';
                    color = '#10b981';
                    break;
                case 5:
                    feedback = 'Sangat Kuat';
                    color = '#059669';
                    break;
            }
            
            return { strength: (strength / 5) * 100, feedback, color };
        }
        
        // Password match checker
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            const matchStatus = document.getElementById('match-status');
            const matchIcon = document.getElementById('match-icon');
            const matchText = document.getElementById('match-text');
            
            if (confirmation.length > 0) {
                matchStatus.classList.remove('hidden');
                
                if (password === confirmation) {
                    matchIcon.className = 'fas fa-check-circle text-green-500 mr-1';
                    matchText.textContent = 'Password cocok';
                    matchText.className = 'text-green-600';
                } else {
                    matchIcon.className = 'fas fa-times-circle text-red-500 mr-1';
                    matchText.textContent = 'Password tidak cocok';
                    matchText.className = 'text-red-600';
                }
            } else {
                matchStatus.classList.add('hidden');
            }
        }
        
        // Event listeners
        document.getElementById('password').addEventListener('input', function() {
            const result = checkPasswordStrength(this.value);
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');
            
            strengthBar.style.width = result.strength + '%';
            strengthBar.style.backgroundColor = result.color;
            strengthText.textContent = result.feedback;
            strengthText.style.color = result.color;
            
            checkPasswordMatch();
        });
        
        document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);
        
        // Handle form submission
        function handleSubmit(event) {
            event.preventDefault();
            
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const waliEmail = document.getElementById('wali_email').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;
            
            // Validation
            if (!name || !email || !waliEmail || !password || !passwordConfirmation) {
                showMessage('error', 'Mohon lengkapi semua field.');
                return;
            }
            
            if (password !== passwordConfirmation) {
                showMessage('error', 'Password dan konfirmasi password tidak cocok.');
                return;
            }
            
            if (password.length < 6) {
                showMessage('error', 'Password minimal 6 karakter.');
                return;
            }
            
            if (!terms) {
                showMessage('error', 'Anda harus menyetujui syarat dan ketentuan.');
                return;
            }
            
            showMessage('success', 'Registrasi berhasil! Mengalihkan ke halaman login...');
        }
        
        // Show message function
        function showMessage(type, message) {
            const errorDiv = document.getElementById('error-message');
            const successDiv = document.getElementById('success-message');
            const errorText = document.getElementById('error-text');
            const successText = document.getElementById('success-text');
            
            errorDiv.classList.add('hidden');
            successDiv.classList.add('hidden');
            
            if (type === 'error') {
                errorText.textContent = message;
                errorDiv.classList.remove('hidden');
            } else if (type === 'success') {
                successText.textContent = message;
                successDiv.classList.remove('hidden');
            }
            
            setTimeout(() => {
                errorDiv.classList.add('hidden');
                successDiv.classList.add('hidden');
            }, 5000);
        }
    </script>
</body>
</html>