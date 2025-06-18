@extends('layouts.santri')

@section('title', 'Profil Santri')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-6 md:p-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Profil Santri</h1>

    <form id="profile-form" action="{{ route('santri.profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Nama Santri -->
            <div>
                <label for="nama_santri" class="block text-sm font-medium text-gray-700">Nama Santri</label>
                <input type="text" id="nama_santri" name="nama_santri" value="{{ $santri->nama_santri }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>

            <!-- Email Santri -->
            <div>
                <label for="email_santri" class="block text-sm font-medium text-gray-700">Email Santri</label>
                <input type="email" id="email_santri" name="email_santri" value="{{ $santri->email_santri }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <input type="text" id="status" value="{{ $santri->status }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-500 cursor-not-allowed" readonly>
            </div>

            <!-- Saldo -->
            <div>
                <label for="saldo" class="block text-sm font-medium text-gray-700">Saldo</label>
                <input type="text" id="saldo" value="{{ number_format($santri->saldo, 0, ',', '.') }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-500 cursor-not-allowed" readonly>
            </div>

            <!-- Kode RFID -->
            <div>
                <label for="kode_rfid" class="block text-sm font-medium text-gray-700">Kode RFID</label>
                <input type="text" id="kode_rfid" value="{{ $santri->kode_rfid }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-500 cursor-not-allowed" readonly>
            </div>

            <!-- Nama Wali -->
            <div>
                <label for="nama_wali" class="block text-sm font-medium text-gray-700">Nama Wali</label>
                <input type="text" id="nama_wali" name="nama_wali" value="{{ $santri->nama_wali }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>

            <!-- Email Wali -->
            <div>
                <label for="email_wali" class="block text-sm font-medium text-gray-700">Email Wali</label>
                <input type="email" id="email_wali" value="{{ $santri->email_wali }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-500 cursor-not-allowed" readonly>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Simpan Perubahan</button>
            <button type="button" id="update-password-btn" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Ubah Password</button>
        </div>
    </form>

    <!-- Password Update Modal -->
    <div id="password-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Ubah Password</h2>
            <form id="password-form" action="{{ route('santri.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                        <input type="password" id="current_password" name="current_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input type="password" id="new_password" name="new_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" id="cancel-password-btn" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 font-medium rounded-md hover:bg-gray-400 focus:outline-none">Batal</button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const updatePasswordBtn = document.getElementById('update-password-btn');
    const passwordModal = document.getElementById('password-modal');
    const cancelPasswordBtn = document.getElementById('cancel-password-btn');

    // Show modal
    updatePasswordBtn.addEventListener('click', function () {
        passwordModal.classList.remove('hidden');
    });

    // Hide modal
    cancelPasswordBtn.addEventListener('click', function () {
        passwordModal.classList.add('hidden');
    });

    // Optional: Close modal when clicking outside
    passwordModal.addEventListener('click', function (event) {
        if (event.target === passwordModal) {
            passwordModal.classList.add('hidden');
        }
    });
});
</script>
@endsection