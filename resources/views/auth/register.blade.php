<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Santri | Kantin PIT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-800">Registrasi Santri</h2>
                <p class="mt-2 text-sm text-gray-500">
                    Isi data diri Anda untuk bergabung dengan Kantin PIT
                </p>
            </div>

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-3 rounded-md" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input id="name" name="name" type="text" required 
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg 
                            text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 
                            focus:ring-green-500 focus:border-green-500 transition duration-200
                            @error('name') border-red-500 @else border-gray-300 @enderror" 
                            value="{{ old('name') }}" placeholder="Masukkan nama lengkap">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Santri</label>
                        <input id="email" name="email" type="email" required 
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg 
                            text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 
                            focus:ring-green-500 focus:border-green-500 transition duration-200
                            @error('email') border-red-500 @else border-gray-300 @enderror" 
                            value="{{ old('email') }}" placeholder="email@example.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="wali_email" class="block text-sm font-medium text-gray-700">Email Wali Santri</label>
                        <input id="wali_email" name="wali_email" type="email" required 
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg 
                            text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 
                            focus:ring-green-500 focus:border-green-500 transition duration-200
                            @error('wali_email') border-red-500 @else border-gray-300 @enderror" 
                            value="{{ old('wali_email') }}" placeholder="wali@example.com">
                        @error('wali_email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required 
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg 
                            text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 
                            focus:ring-green-500 focus:border-green-500 transition duration-200
                            @error('password') border-red-500 @else border-gray-300 @enderror" 
                            placeholder="Minimal 6 karakter">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg 
                            text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 
                            focus:ring-green-500 focus:border-green-500 transition duration-200" 
                            placeholder="Ulangi password">
                    </div>
                </div>

                <div>
                    <button type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent 
                        text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 
                        transition duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-user-plus text-green-200 group-hover:text-green-100"></i>
                        </span>
                        Daftar
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p class="text-sm text-gray-500">
                        Sudah punya akun? 
                        <a href="{{ route('auth.login') }}" class="font-medium text-green-600 hover:text-green-500">
                            Login di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-white py-4 text-center text-gray-500 text-sm">
        <p>© {{ date('Y') }} Kantin PIT. All rights reserved.</p>
    </footer>
</body>
</html>