@extends('layouts.admin')

@section('title', 'Persetujuan Santri')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 sm:space-y-6 lg:space-y-8">
        <!-- Enhanced Header Section -->
        <div class="relative overflow-hidden">
            <div
                class="absolute inset-0 bg-gradient-to-r from-indigo-600/10 via-purple-600/10 to-pink-600/10 rounded-lg sm:rounded-2xl">
            </div>
            <div
                class="relative bg-white/80 backdrop-blur-sm rounded-lg sm:rounded-2xl p-4 sm:p-6 lg:p-8 border border-white/20 shadow-xl">
                <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0 gap-4">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div
                                class="p-1.5 sm:p-2 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg sm:rounded-xl">
                                <i class="fas fa-user-check text-white text-sm sm:text-lg"></i>
                            </div>
                            <h1
                                class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                                Persetujuan Santri
                            </h1>
                        </div>
                        <p class="text-sm sm:text-base text-gray-600 font-medium">Kelola dan verifikasi pendaftaran santri
                            baru dengan sistem yang terintegrasi</p>
                    </div>
                    <div class="flex items-center justify-between sm:justify-end gap-3 sm:gap-4">
                        <div class="text-center sm:text-right">
                            <div class="text-xl sm:text-2xl font-bold text-indigo-600">{{ $pendingSantris->count() }}</div>
                            <div class="text-xs sm:text-sm text-gray-500 font-medium">Menunggu Review</div>
                        </div>
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-white text-sm sm:text-base"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Alert Messages -->
        @if (session('success'))
            <div class="relative overflow-hidden bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-lg sm:rounded-2xl p-4 sm:p-6 shadow-lg"
                role="alert">
                <div class="absolute inset-0 bg-emerald-500/5"></div>
                <div class="relative flex items-start sm:items-center gap-3 sm:gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-emerald-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm sm:text-base"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-emerald-800 text-sm sm:text-base">Berhasil!</h3>
                        <p class="text-emerald-700 text-sm sm:text-base">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="relative overflow-hidden bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-lg sm:rounded-2xl p-4 sm:p-6 shadow-lg"
                role="alert">
                <div class="absolute inset-0 bg-red-500/5"></div>
                <div class="relative flex items-start sm:items-center gap-3 sm:gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-red-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-white text-sm sm:text-base"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-red-800 text-sm sm:text-base">Error!</h3>
                        <p class="text-red-700 text-sm sm:text-base">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Enhanced Main Content Card -->
        <div class="relative overflow-hidden">
            <div
                class="absolute inset-0 bg-gradient-to-br from-white via-gray-50/50 to-indigo-50/30 rounded-2xl sm:rounded-3xl">
            </div>
            <div
                class="relative bg-white/90 backdrop-blur-sm rounded-2xl sm:rounded-3xl shadow-2xl border border-white/50 overflow-hidden">

                <!-- Enhanced Header -->
                <div class="relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/5 via-purple-600/5 to-pink-600/5"></div>
                    <div class="relative p-4 sm:p-6 lg:p-8 border-b border-gray-100">
                        <div
                            class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0 gap-4">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div
                                    class="p-2 sm:p-3 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl sm:rounded-2xl shadow-lg">
                                    <i class="fas fa-users text-white text-lg sm:text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800">Daftar Santri Baru
                                    </h2>
                                    <p class="text-sm sm:text-base text-gray-600">Verifikasi dan kelola pendaftaran</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center sm:justify-end">
                                <div
                                    class="px-3 py-2 sm:px-4 bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-800 rounded-full border border-yellow-200 shadow-sm">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                                        <span class="font-semibold text-sm sm:text-base">{{ $pendingSantris->count() }}
                                            Menunggu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Table for Desktop -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-indigo-50/30 border-b border-gray-100">
                                <th class="text-left py-4 px-6 font-semibold text-gray-700 uppercase tracking-wide text-sm">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-user text-indigo-500"></i>
                                        Nama Santri
                                    </div>
                                </th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-700 uppercase tracking-wide text-sm">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-envelope text-indigo-500"></i>
                                        Email
                                    </div>
                                </th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-700 uppercase tracking-wide text-sm">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-user-tie text-indigo-500"></i>
                                        Email Wali
                                    </div>
                                </th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-700 uppercase tracking-wide text-sm">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-calendar text-indigo-500"></i>
                                        Tanggal Daftar
                                    </div>
                                </th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-700 uppercase tracking-wide text-sm">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-cogs text-indigo-500"></i>
                                        Aksi
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($pendingSantris as $santri)
                                <tr
                                    class="group hover:bg-gradient-to-r hover:from-indigo-50/30 hover:to-purple-50/20 transition-all duration-300">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                                                <span
                                                    class="text-white font-semibold text-sm">{{ substr($santri->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800">{{ $santri->name }}</div>
                                                <div class="text-sm text-gray-500">ID:
                                                    #{{ str_pad($santri->id, 4, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-at text-gray-400"></i>
                                            <span class="text-gray-700">{{ $santri->email }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-2">
                                            @if ($santri->wali_email)
                                                <i class="fas fa-check-circle text-green-500"></i>
                                                <span class="text-gray-700">{{ $santri->wali_email }}</span>
                                            @else
                                                <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                                                <span class="text-gray-500 italic">Tidak ada</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-gray-700 font-medium">{{ $santri->created_at->format('d/m/Y') }}</span>
                                            <span class="text-sm text-gray-500">{{ $santri->created_at->format('H:i') }}
                                                WIB</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <form action="{{ route('admin.santri.approve', $santri->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="group/btn relative overflow-hidden bg-gradient-to-r from-emerald-500 to-green-600 text-white px-4 py-2 rounded-xl hover:from-emerald-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                                    <div
                                                        class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-300">
                                                    </div>
                                                    <div class="relative flex items-center gap-2">
                                                        <i class="fas fa-check text-sm"></i>
                                                        <span class="font-medium">Setujui</span>
                                                    </div>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.santri.reject', $santri->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="group/btn relative overflow-hidden bg-gradient-to-r from-red-500 to-rose-600 text-white px-4 py-2 rounded-xl hover:from-red-600 hover:to-rose-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                                    <div
                                                        class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-300">
                                                    </div>
                                                    <div class="relative flex items-center gap-2">
                                                        <i class="fas fa-times text-sm"></i>
                                                        <span class="font-medium">Tolak</span>
                                                    </div>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12">
                                        <div class="text-center">
                                            <div
                                                class="w-20 h-20 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-user-check text-3xl text-gray-400"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-600 mb-2">Tidak Ada Santri Menunggu
                                            </h3>
                                            <p class="text-gray-500">Semua pendaftaran telah diproses atau belum ada
                                                pendaftaran baru.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card Layout -->
                <div class="lg:hidden space-y-4 p-4 sm:p-6">
                    @forelse ($pendingSantris as $santri)
                        <div
                            class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-all duration-300">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-white font-semibold">{{ substr($santri->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800 text-base">{{ $santri->name }}</h3>
                                        <p class="text-sm text-gray-500">ID:
                                            #{{ str_pad($santri->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-gray-700 font-medium">
                                        {{ $santri->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $santri->created_at->format('H:i') }} WIB</div>
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-sm">
                                    <i class="fas fa-envelope text-gray-400 w-4"></i>
                                    <span class="text-gray-700 truncate">{{ $santri->email }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <i class="fas fa-user-tie text-gray-400 w-4"></i>
                                    @if ($santri->wali_email)
                                        <span class="text-gray-700 truncate">{{ $santri->wali_email }}</span>
                                    @else
                                        <span class="text-gray-500 italic">Tidak ada email wali</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                                <form action="{{ route('admin.santri.approve', $santri->id) }}" method="POST"
                                    class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="w-full group/btn relative overflow-hidden bg-gradient-to-r from-emerald-500 to-green-600 text-white px-4 py-2.5 rounded-lg hover:from-emerald-600 hover:to-green-700 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                        <div
                                            class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-300">
                                        </div>
                                        <div class="relative flex items-center justify-center gap-2">
                                            <i class="fas fa-check text-sm"></i>
                                            <span class="font-medium">Setujui</span>
                                        </div>
                                    </button>
                                </form>
                                <form action="{{ route('admin.santri.reject', $santri->id) }}" method="POST"
                                    class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="w-full group/btn relative overflow-hidden bg-gradient-to-r from-red-500 to-rose-600 text-white px-4 py-2.5 rounded-lg hover:from-red-600 hover:to-rose-700 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                        <div
                                            class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-300">
                                        </div>
                                        <div class="relative flex items-center justify-center gap-2">
                                            <i class="fas fa-times text-sm"></i>
                                            <span class="font-medium">Tolak</span>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div
                                class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-user-check text-2xl sm:text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-base sm:text-lg font-semibold text-gray-600 mb-2">Tidak Ada Santri Menunggu
                            </h3>
                            <p class="text-sm sm:text-base text-gray-500 px-4">Semua pendaftaran telah diproses atau belum
                                ada pendaftaran baru.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Enhanced animations and effects */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Custom gradient borders */
        .gradient-border {
            position: relative;
            background: linear-gradient(45deg, #f3f4f6, #ffffff);
            border-radius: 1.5rem;
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 1.5rem;
            padding: 1px;
            background: linear-gradient(45deg, #6366f1, #8b5cf6, #ec4899);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: exclude;
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
        }

        /* Enhanced hover effects for table rows */
        tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        tbody tr:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.05);
        }

        /* Button pulse effect */
        @keyframes pulse-success {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            }

            70% {
                box-shadow: 0 0 0 4px rgba(34, 197, 94, 0);
            }
        }

        @keyframes pulse-danger {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }

            70% {
                box-shadow: 0 0 0 4px rgba(239, 68, 68, 0);
            }
        }

        button[type="submit"]:focus {
            outline: none;
        }

        button[type="submit"]:focus:first-of-type {
            animation: pulse-success 1.5s infinite;
        }

        button[type="submit"]:focus:last-of-type {
            animation: pulse-danger 1.5s infinite;
        }

        /* Smooth loading effect */
        .table-loading {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        /* Mobile specific improvements */
        @media (max-width: 640px) {
            .truncate {
                max-width: 180px;
            }
        }

        @media (max-width: 480px) {
            .truncate {
                max-width: 140px;
            }
        }

        /* Smooth transitions for responsive elements */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Enhanced touch targets for mobile */
        @media (max-width: 1024px) {
            button[type="submit"] {
                min-height: 44px;
                touch-action: manipulation;
            }
        }
    </style>
@endsection
