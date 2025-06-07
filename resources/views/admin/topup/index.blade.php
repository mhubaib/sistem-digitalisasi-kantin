@extends('layouts.admin')

@section('title', 'Manajemen Top-up')

@section('content')
    <div class="container px-6 mx-auto max-w-full">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Manajemen Top-up</h2>
            <a href="{{ route('admin.topup.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow-lg transform transition-all duration-300 hover:scale-105 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                <span>Top-up Baru</span>
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6 w-full">
            <div
                class="bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl shadow-xl p-6 text-white transform transition-all duration-300 hover:scale-105 w-full">
                <div class="flex items-center justify-between w-full">
                    <div>
                        <p class="text-sm opacity-80">Total Top-up Hari Ini</p>
                        <h3 class="text-2xl font-bold">Rp {{ number_format($todayTopups ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <i class="fas fa-money-bill-wave text-4xl opacity-80"></i>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-blue-600 to-cyan-500 rounded-xl shadow-xl p-6 text-white transform transition-all duration-300 hover:scale-105 w-full">
                <div class="flex items-center justify-between w-full">
                    <div>
                        <p class="text-sm opacity-80">Total Top-up Bulan Ini</p>
                        <h3 class="text-2xl font-bold">Rp {{ number_format($monthTopups ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <i class="fas fa-chart-line text-4xl opacity-80"></i>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-emerald-600 to-teal-500 rounded-xl shadow-xl p-6 text-white transform transition-all duration-300 hover:scale-105 w-full">
                <div class="flex items-center justify-between w-full">
                    <div>
                        <p class="text-sm opacity-80">Total Transaksi Top-up</p>
                        <h3 class="text-2xl font-bold">{{ $totalTransactions ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-receipt text-4xl opacity-80"></i>
                </div>
            </div>
        </div>

        <!-- Topup History Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-x-auto max-w-full">
            <div class="p-6">
                <div class="flex flex-col w-full">
                    <div class="-my-2 overflow-x-hidden sm:overflow-x-auto w-full max-w-full">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8 w-full">
                            <table class="min-w-full divide-y divide-gray-200 w-full table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-normal">
                                            Tanggal</th>
                                        <th scope="col"
                                            class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-normal">
                                            Nama Santri</th>
                                        <th scope="col"
                                            class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-normal">
                                            Jumlah</th>
                                        <th scope="col"
                                            class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-normal">
                                            Metode</th>
                                        <th scope="col"
                                            class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-normal">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($topups as $topup)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-4 sm:px-6 py-4 whitespace-normal text-sm text-gray-500">
                                                {{ $topup->created_at->format('d M Y H:i') }}
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-normal">
                                                <div class="flex flex-col sm:flex-row items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div
                                                            class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                            <span
                                                                class="text-indigo-800 font-semibold">{{ substr($topup->santri->user->name ?? 'U', 0, 1) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-0 sm:ml-4 mt-2 sm:mt-0">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $topup->santri->user->name ?? 'Unknown' }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            ID: {{ $topup->santri_id }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-normal">
                                                <div class="text-sm font-medium text-gray-900">
                                                    Rp {{ number_format($topup->amount, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-normal">
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if ($topup->method == 'cash') bg-green-100 text-green-800
                                            @elseif($topup->method == 'transfer') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($topup->method) }}
                                                </span>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-normal">
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                                    Sukses
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                                Belum ada data top-up
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if ($topups->hasPages())
                    <div class="mt-4 w-full flex justify-center">
                        {{ $topups->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
