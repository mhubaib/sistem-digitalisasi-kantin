@extends('layouts.admin')

@section('title', 'Top-up Baru')

@section('content')
    <div class="container px-6 mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex items-center text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('admin.topup.index') }}" class="hover:text-blue-600 flex items-center">
                <i class="fas fa-home mr-1"></i> Top-up
            </a>
            <span class="mx-2">/</span>
            <span class="text-gray-700 font-semibold">Top-up Baru</span>
        </nav>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 sm:p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Top-up Saldo Santri</h2>

                @if (session('success'))
                    <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <p class="font-semibold">Terjadi kesalahan:</p>
                        </div>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.topup.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Santri Selection -->
                    <div class="form-group">
                        <label for="santri_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Santri
                        </label>
                        <div class="relative">
                            <select id="santri_id" name="santri_id" required
                                class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-lg shadow-sm transition duration-150 ease-in-out">
                                <option value="">Pilih Santri</option>
                                @foreach ($santris as $santri)
                                    <option value="{{ $santri->id }}"
                                        {{ old('santri_id') == $santri->id ? 'selected' : '' }}>
                                        {{ $santri->user->name }} - Saldo: Rp
                                        {{ number_format($santri->saldo, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Amount Input -->
                    <div class="form-group">
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah Top-up
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="amount" id="amount" required min="1000"
                                class="block w-full pl-12 pr-12 py-2.5 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-lg transition duration-150 ease-in-out"
                                placeholder="0" value="{{ old('amount') }}">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">.00</span>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Minimal top-up Rp 1.000</p>
                    </div>

                    <!-- Payment Method -->
                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Metode Pembayaran
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <label class="relative">
                                <input type="radio" name="method" value="cash" class="peer sr-only"
                                    {{ old('method') == 'cash' ? 'checked' : '' }}>
                                <div
                                    class="w-full p-4 bg-white border rounded-lg cursor-pointer transition-all duration-200 ease-in-out
                                peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 hover:border-gray-300">
                                    <div class="flex items-center">
                                        <i class="fas fa-money-bill-wave text-2xl mr-3 text-green-500"></i>
                                        <div>
                                            <h4 class="font-medium">Tunai</h4>
                                            <p class="text-sm text-gray-500">Pembayaran cash</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative">
                                <input type="radio" name="method" value="transfer" class="peer sr-only"
                                    {{ old('method') == 'transfer' ? 'checked' : '' }}>
                                <div
                                    class="w-full p-4 bg-white border rounded-lg cursor-pointer transition-all duration-200 ease-in-out
                                peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 hover:border-gray-300">
                                    <div class="flex items-center">
                                        <i class="fas fa-university text-2xl mr-3 text-blue-500"></i>
                                        <div>
                                            <h4 class="font-medium">Transfer Bank</h4>
                                            <p class="text-sm text-gray-500">Transfer via bank</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative">
                                <input type="radio" name="method" value="manual" class="peer sr-only"
                                    {{ old('method') == 'manual' ? 'checked' : '' }}>
                                <div
                                    class="w-full p-4 bg-white border rounded-lg cursor-pointer transition-all duration-200 ease-in-out
                                peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 hover:border-gray-300">
                                    <div class="flex items-center">
                                        <i class="fas fa-hand-holding-usd text-2xl mr-3 text-yellow-500"></i>
                                        <div>
                                            <h4 class="font-medium">Manual</h4>
                                            <p class="text-sm text-gray-500">Input manual</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative">
                                <input type="radio" name="method" value="lainnya" class="peer sr-only"
                                    {{ old('method') == 'lainnya' ? 'checked' : '' }}>
                                <div
                                    class="w-full p-4 bg-white border rounded-lg cursor-pointer transition-all duration-200 ease-in-out
                                peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 hover:border-gray-300">
                                    <div class="flex items-center">
                                        <i class="fas fa-ellipsis-h text-2xl mr-3 text-gray-500"></i>
                                        <div>
                                            <h4 class="font-medium">Lainnya</h4>
                                            <p class="text-sm text-gray-500">Metode lain</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transform transition-all duration-300 hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Proses Top-up
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Format amount input with thousand separator
        const amountInput = document.getElementById('amount');
        amountInput.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, "");
            if (value === "") return;
            this.value = parseInt(value).toLocaleString('id-ID');
        });
    </script>
@endpush
