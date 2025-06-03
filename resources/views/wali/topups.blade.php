@extends('layouts.wali')

@section('title', 'Riwayat Topup Wali')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <!-- Header Section with Gradient -->
    <div class="relative mb-8">
        <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-800 rounded-2xl opacity-10"></div>
        <div class="relative bg-white/80 backdrop-blur-sm rounded-2xl p-8 border border-green-100 shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-green-700 to-green-900 bg-clip-text text-transparent">
                        Riwayat Topup Santri
                    </h1>
                    <p class="text-gray-600 mt-2">Kelola dan pantau semua transaksi topup santri Anda</p>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <div class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-medium">
                        <i class="fas fa-wallet mr-2"></i>
                        {{ $topups->total() }} Transaksi
                    </div>
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        {{ now()->format('d F Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Filter Section -->
    <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-8 py-6 border-b border-blue-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-filter text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Filter & Pencarian</h2>
                    <p class="text-sm text-gray-600">Gunakan filter untuk menemukan data topup yang spesifik</p>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('wali.topups') }}" class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                <!-- Sumber Topup -->
                <div class="space-y-2">
                    <label for="source" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">
                        <i class="fas fa-user-shield text-blue-500 mr-2"></i>
                        Sumber Topup
                    </label>
                    <select name="source" id="source" 
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                        <option value="">Semua Sumber</option>
                        <option value="admin" {{ request('source') == 'admin' ? 'selected' : '' }}>
                            <i class="fas fa-user-cog"></i> Admin
                        </option>
                        <option value="wali" {{ request('source') == 'wali' ? 'selected' : '' }}>
                            <i class="fas fa-user-friends"></i> Wali
                        </option>
                    </select>
                </div>

                <!-- Metode Topup -->
                <div class="space-y-2">
                    <label for="method" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">
                        <i class="fas fa-credit-card text-green-500 mr-2"></i>
                        Metode Pembayaran
                    </label>
                    <select name="method" id="method"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white">
                        <option value="">Semua Metode</option>
                        <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="transfer" {{ request('method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="manual" {{ request('method') == 'manual' ? 'selected' : '' }}>Manual</option>
                        <option value="lainnya" {{ request('method') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Nama Santri -->
                <div class="space-y-2">
                    <label for="santri_name" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">
                        <i class="fas fa-graduation-cap text-purple-500 mr-2"></i>
                        Nama Santri
                    </label>
                    <select name="santri_name" id="santri_name"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white">
                        <option value="">Semua Santri</option>
                        @foreach ($santris as $santri)
                            <option value="{{ $santri->user->name }}" {{ request('santri_name') == $santri->user->name ? 'selected' : '' }}>
                                {{ $santri->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Mulai -->
                <div class="space-y-2">
                    <label for="start_date" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">
                        <i class="fas fa-calendar-day text-orange-500 mr-2"></i>
                        Tanggal Mulai
                    </label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-white">
                </div>

                <!-- Tanggal Akhir -->
                <div class="space-y-2">
                    <label for="end_date" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">
                        <i class="fas fa-calendar-check text-red-500 mr-2"></i>
                        Tanggal Akhir
                    </label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center justify-between mt-8 pt-6 border-t border-gray-200">
                <div class="flex flex-wrap gap-3">
                    <button type="submit"
                            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 flex items-center space-x-2">
                        <i class="fas fa-search"></i>
                        <span>Terapkan Filter</span>
                    </button>
                    
                    @if (request()->hasAny(['source', 'method', 'santri_name', 'start_date', 'end_date']))
                        <a href="{{ route('wali.topups') }}"
                           class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 flex items-center space-x-2">
                            <i class="fas fa-undo"></i>
                            <span>Reset Filter</span>
                        </a>
                    @endif
                </div>

                <div class="hidden md:flex items-center space-x-4 text-sm text-gray-500">
                    <div class="flex items-center space-x-1">
                        <i class="fas fa-info-circle"></i>
                        <span>Menampilkan {{ $topups->count() }} dari {{ $topups->total() }} data</span>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Topup Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
        @forelse ($topups as $topup)
            <div class="group relative overflow-hidden">
                <!-- Card Background with Gradient -->
                <div class="absolute inset-0 bg-gradient-to-br from-white to-gray-50 rounded-2xl"></div>
                
                <!-- Main Card -->
                <div class="relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 border border-gray-100 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <!-- Card Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-arrow-up text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Topup #{{ $topup->id }}</h3>
                                <p class="text-sm text-gray-500">{{ $topup->created_at->format('d M Y, H:i') }} WIB</p>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide">
                            <i class="fas fa-check-circle mr-1"></i>
                            Berhasil
                        </div>
                    </div>

                    <!-- Amount Display -->
                    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-4 mb-4">
                        <div class="text-center">
                            <p class="text-sm text-green-600 font-medium mb-1">Jumlah Topup</p>
                            <p class="text-3xl font-bold text-green-700">
                                Rp {{ number_format($topup->amount, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="space-y-3">
                        <!-- Santri Info -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-xs">
                                    {{ strtoupper(substr($topup->santri->user->name ?? 'N/A', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $topup->santri->user->name ?? 'Tidak diketahui' }}</p>
                                    <p class="text-xs text-gray-500">Nama Santri</p>
                                </div>
                            </div>
                        </div>

                        <!-- Method & Source -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-credit-card text-blue-500"></i>
                                    <div>
                                        <p class="text-xs text-blue-600 font-medium">Metode</p>
                                        <p class="text-sm font-semibold text-blue-800 capitalize">{{ $topup->method }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-3 bg-purple-50 rounded-lg">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user-shield text-purple-500"></i>
                                    <div>
                                        <p class="text-xs text-purple-600 font-medium">Sumber</p>
                                        <p class="text-sm font-semibold text-purple-800 capitalize">{{ $topup->source }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span class="flex items-center space-x-1">
                                <i class="fas fa-clock"></i>
                                <span>{{ $topup->created_at->diffForHumans() }}</span>
                            </span>
                            <span class="bg-gray-100 px-2 py-1 rounded text-gray-600 font-mono">
                                ID: {{ $topup->id }}
                            </span>
                        </div>
                    </div>

                    <!-- Hover Effect Decoration -->
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-400/10 to-green-600/10 rounded-full -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-300"></div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="col-span-full">
                <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-12 text-center border border-gray-100 shadow-lg">
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-wallet text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Data Topup</h3>
                    <p class="text-gray-600 mb-6">Belum ada transaksi topup yang sesuai dengan filter yang Anda pilih.</p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('wali.topups') }}" 
                           class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 flex items-center justify-center space-x-2">
                            <i class="fas fa-refresh"></i>
                            <span>Reset Filter</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Enhanced Pagination -->
    @if($topups->hasPages())
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 border border-gray-100 shadow-lg">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Menampilkan {{ $topups->firstItem() ?? 0 }} - {{ $topups->lastItem() ?? 0 }} dari {{ $topups->total() }} hasil
                </div>
                <div class="pagination-wrapper">
                    {{ $topups->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

<style>
/* Custom Pagination Styling */
.pagination-wrapper .pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 0.5rem;
}

.pagination-wrapper .page-item {
    border-radius: 0.75rem;
    overflow: hidden;
}

.pagination-wrapper .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1rem;
    color: #6b7280;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s;
    border-radius: 0.75rem;
    min-width: 2.5rem;
    height: 2.5rem;
}

.pagination-wrapper .page-item.active .page-link {
    background: linear-gradient(135deg, #059669, #047857);
    color: white;
    border-color: #059669;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.pagination-wrapper .page-link:hover {
    background: #e5e7eb;
    border-color: #d1d5db;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.pagination-wrapper .page-item.active .page-link:hover {
    background: linear-gradient(135deg, #047857, #065f46);
}

/* Form Enhancement */
select:focus, input:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

/* Card Enhancement */
.topup-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.topup-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Animation */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slide-in {
    animation: slideInUp 0.6s ease-out;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .grid.xl\\:grid-cols-3 {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
    
    .xl\\:grid-cols-5 {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
}
</style>
@endsection