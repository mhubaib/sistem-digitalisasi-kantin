@extends('layouts.admin')

@section('content')
    <div class="max-w-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/40">
        <!-- Enhanced Header Section -->
        <div class="bg-white/80 backdrop-blur-sm border-b border-gray-200/60 shadow-sm">
            <div class="px-6 py-5">
                <!-- Modern Breadcrumb Navigation -->
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center text-sm font-medium text-slate-600 hover:text-blue-600 transition-all duration-300 hover:scale-105 group">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-blue-100 flex items-center justify-center mr-2 transition-all duration-300">
                                    <i class="fas fa-home w-3.5 h-3.5 text-gray-500 group-hover:text-blue-600"></i>
                                </div>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-300 mx-2 text-xs"></i>
                                <a href="{{ route('admin.santri.index') }}"
                                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-all duration-300 hover:scale-105">
                                    Data Santri
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-300 mx-2 text-xs"></i>
                                <span class="text-sm font-medium text-slate-800 px-2.5 py-1 bg-blue-100 rounded-full">Update
                                    Status</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Enhanced Page Title -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                                <i class="fas fa-user-edit text-white text-lg"></i>
                            </div>
                            <h1
                                class="text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                                Update Status Santri
                            </h1>
                        </div>
                        <p class="text-slate-600 text-sm font-medium">Kelola status aktif/non-aktif santri dengan mudah dan
                            aman</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Main Content -->
        <div class="p-1">
            <div class="max-w-5xl mx-auto">
                <!-- Main Card with Enhanced Design -->
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-slate-50 to-blue-50/50 border-b border-gray-200/60 px-8 py-6">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
                                <i class="fas fa-cog text-white text-sm"></i>
                            </div>
                            <h2 class="text-xl font-semibold text-slate-800">Pengaturan Status Santri</h2>
                        </div>
                    </div>

                    <div class="p-8">
                        <form action="{{ route('admin.santri.status.update', $santri->id) }}" method="POST"
                            class="space-y-8">
                            @csrf
                            @method('PUT')

                            <!-- Enhanced Santri Info Section -->
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-gradient-to-r from-emerald-500 to-teal-600 flex items-center justify-center">
                                        <i class="fas fa-info-circle text-white text-sm"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-slate-800">Informasi Santri</h3>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <!-- Enhanced Santri Information Card -->
                                    <div class="group">
                                        <div
                                            class="bg-gradient-to-br from-blue-50/50 to-indigo-50/30 border border-blue-200/40 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg hover:border-blue-300/60">
                                            <div class="flex items-center space-x-3 mb-5">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center shadow-md">
                                                    <i class="fas fa-user-graduate text-white"></i>
                                                </div>
                                                <h4 class="text-lg font-semibold text-slate-800">Data Santri</h4>
                                            </div>

                                            <div class="space-y-4">
                                                <div class="group/item">
                                                    <label class="block text-sm font-semibold text-slate-600 mb-1.5">Nama
                                                        Santri</label>
                                                    <div
                                                        class="bg-white/70 backdrop-blur-sm rounded-xl px-4 py-3 border border-slate-200/60 group-hover/item:border-blue-300/60 transition-all duration-200">
                                                        <span
                                                            class="text-slate-900 font-medium">{{ $santri->user->name }}</span>
                                                    </div>
                                                </div>

                                                <div class="group/item">
                                                    <label class="block text-sm font-semibold text-slate-600 mb-1.5">Email
                                                        Santri</label>
                                                    <div
                                                        class="bg-white/70 backdrop-blur-sm rounded-xl px-4 py-3 border border-slate-200/60 group-hover/item:border-blue-300/60 transition-all duration-200">
                                                        <span
                                                            class="text-slate-900 font-medium">{{ $santri->user->email }}</span>
                                                    </div>
                                                </div>

                                                <div class="group/item">
                                                    <label class="block text-sm font-semibold text-slate-600 mb-1.5">ID
                                                        Santri</label>
                                                    <div
                                                        class="bg-white/70 backdrop-blur-sm rounded-xl px-4 py-3 border border-slate-200/60 group-hover/item:border-blue-300/60 transition-all duration-200">
                                                        <span class="text-slate-900 font-mono font-bold text-lg">
                                                            #{{ str_pad($santri->id, 4, '0', STR_PAD_LEFT) }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="group/item">
                                                    <label class="block text-sm font-semibold text-slate-600 mb-1.5">Saldo
                                                        Tersedia</label>
                                                    <div
                                                        class="bg-gradient-to-r from-emerald-50 to-teal-50 backdrop-blur-sm rounded-xl px-4 py-3 border border-emerald-200/60 group-hover/item:border-emerald-300/80 transition-all duration-200">
                                                        <span class="text-emerald-800 font-bold text-lg">
                                                            Rp {{ number_format($santri->saldo ?? 0, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Enhanced Wali Information & Status Card -->
                                    <div class="space-y-6">
                                        <!-- Wali Information -->
                                        <div class="group">
                                            <div
                                                class="bg-gradient-to-br from-emerald-50/50 to-teal-50/30 border border-emerald-200/40 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg hover:border-emerald-300/60">
                                                <div class="flex items-center space-x-3 mb-5">
                                                    <div
                                                        class="w-10 h-10 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 flex items-center justify-center shadow-md">
                                                        <i class="fas fa-user-friends text-white"></i>
                                                    </div>
                                                    <h4 class="text-lg font-semibold text-slate-800">Data Wali</h4>
                                                </div>

                                                <div class="space-y-4">
                                                    <div class="group/item">
                                                        <label
                                                            class="block text-sm font-semibold text-slate-600 mb-1.5">Nama
                                                            Wali</label>
                                                        <div
                                                            class="bg-white/70 backdrop-blur-sm rounded-xl px-4 py-3 border border-slate-200/60 group-hover/item:border-emerald-300/60 transition-all duration-200">
                                                            <span
                                                                class="text-slate-900 font-medium">{{ $santri->wali->name ?? 'Belum Terdaftar' }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="group/item">
                                                        <label
                                                            class="block text-sm font-semibold text-slate-600 mb-1.5">Email
                                                            Wali</label>
                                                        <div
                                                            class="bg-white/70 backdrop-blur-sm rounded-xl px-4 py-3 border border-slate-200/60 group-hover/item:border-emerald-300/60 transition-all duration-200">
                                                            <span
                                                                class="text-slate-900 font-medium">{{ $santri->wali->email ?? 'Belum Terdaftar' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Enhanced Current Status -->
                                        <div class="group">
                                            <div
                                                class="bg-gradient-to-br from-purple-50/50 to-indigo-50/30 border border-purple-200/40 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg hover:border-purple-300/60">
                                                <div class="flex items-center space-x-3 mb-5">
                                                    <div
                                                        class="w-10 h-10 rounded-xl bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center shadow-md">
                                                        <i class="fas fa-toggle-on text-white"></i>
                                                    </div>
                                                    <h4 class="text-lg font-semibold text-slate-800">Status Saat Ini</h4>
                                                </div>

                                                <div class="flex justify-center">
                                                    @if ($santri->user->active)
                                                        <div
                                                            class="inline-flex items-center px-6 py-3 rounded-2xl text-sm font-bold bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-lg">
                                                            <div class="w-3 h-3 bg-white rounded-full mr-3 animate-pulse">
                                                            </div>
                                                            <i class="fas fa-check-circle mr-2"></i>
                                                            Status Aktif
                                                        </div>
                                                    @else
                                                        <div
                                                            class="inline-flex items-center px-6 py-3 rounded-2xl text-sm font-bold bg-gradient-to-r from-red-500 to-rose-600 text-white shadow-lg">
                                                            <div class="w-3 h-3 bg-white rounded-full mr-3"></div>
                                                            <i class="fas fa-times-circle mr-2"></i>
                                                            Status Non Aktif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Status Selection Section -->
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-gradient-to-r from-amber-500 to-orange-600 flex items-center justify-center">
                                        <i class="fas fa-edit text-white text-sm"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-slate-800">Perubahan Status</h3>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-slate-50/50 to-gray-50/30 border border-slate-200/40 rounded-2xl p-8">
                                    <div class="space-y-6">
                                        <p class="text-slate-600 text-center font-medium mb-8">Pilih status baru untuk
                                            santri ini</p>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- Active Status Option -->
                                            <label for="status_active" class="group cursor-pointer">
                                                <div
                                                    class="relative bg-white border-2 border-emerald-200 rounded-2xl p-3 transition-all duration-300 hover:border-emerald-400 hover:shadow-lg {{ $santri->user->active ? 'border-emerald-400 bg-emerald-50/50 shadow-lg' : '' }}">
                                                    <div class="flex items-center space-x-4">
                                                        <input type="radio" id="status_active" name="active"
                                                            value="1"
                                                            class="w-5 h-5 text-emerald-600 focus:ring-emerald-500 border-emerald-300 transition-all duration-200"
                                                            {{ $santri->user->active ? 'checked' : '' }}>

                                                        <div class="flex-1">
                                                            <div class="flex items-center space-x-3 mb-2">
                                                                <div
                                                                    class="w-10 h-10 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 flex items-center justify-center shadow-md">
                                                                    <i class="fas fa-check-circle text-white"></i>
                                                                </div>
                                                                <span class="text-lg font-bold text-slate-800">Status
                                                                    Aktif</span>
                                                            </div>
                                                            <p class="text-sm text-slate-600">Santri dapat mengakses semua
                                                                fitur sistem</p>
                                                        </div>
                                                    </div>

                                                    @if ($santri->user->active)
                                                        <div
                                                            class="absolute -top-2 -right-2 w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center shadow-lg">
                                                            <i class="fas fa-check text-white text-xs"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </label>

                                            <!-- Inactive Status Option -->
                                            <label for="status_inactive" class="group cursor-pointer">
                                                <div
                                                    class="relative bg-white border-2 border-red-200 rounded-2xl p-3 transition-all duration-300 hover:border-red-400 hover:shadow-lg {{ !$santri->user->active ? 'border-red-400 bg-red-50/50 shadow-lg' : '' }}">
                                                    <div class="flex items-center space-x-4">
                                                        <input type="radio" id="status_inactive" name="active"
                                                            value="0"
                                                            class="w-5 h-5 text-red-600 focus:ring-red-500 border-red-300 transition-all duration-200"
                                                            {{ !$santri->user->active ? 'checked' : '' }}>

                                                        <div class="flex-1">
                                                            <div class="flex items-center space-x-3 mb-2">
                                                                <div
                                                                    class="w-10 h-10 rounded-xl bg-gradient-to-r from-red-500 to-rose-600 flex items-center justify-center shadow-md">
                                                                    <i class="fas fa-times-circle text-white"></i>
                                                                </div>
                                                                <span class="text-lg font-bold text-slate-800">Status Non
                                                                    Aktif</span>
                                                            </div>
                                                            <p class="text-sm text-slate-600">Santri tidak dapat mengakses
                                                                sistem</p>
                                                        </div>
                                                    </div>

                                                    @if (!$santri->user->active)
                                                        <div
                                                            class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center shadow-lg">
                                                            <i class="fas fa-check text-white text-xs"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Action Buttons -->
                            <div
                                class="bg-gradient-to-r from-slate-50 to-gray-50 rounded-2xl p-6 border border-slate-200/60">
                                <div class="flex flex-col gap-4">
                                    <a href="{{ route('admin.santri.index') }}"
                                        class="group inline-flex items-center px-6 py-3 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 hover:border-slate-400 focus:outline-none focus:ring-4 focus:ring-slate-200 transition-all duration-200 hover:scale-105">
                                        <i
                                            class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform duration-200"></i>
                                        Kembali
                                    </a>

                                    <button type="submit"
                                        class="group inline-flex items-center px-8 py-3 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200 hover:scale-105 hover:shadow-xl">
                                        <i
                                            class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom animations and effects */
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

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Enhanced focus states */
        input[type="radio"]:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Custom backdrop blur for better browser support */
        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        /* Smooth transitions for interactive elements */
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }

        .group:hover .group-hover\:-translate-x-1 {
            transform: translateX(-0.25rem);
        }
    </style>
@endsection
