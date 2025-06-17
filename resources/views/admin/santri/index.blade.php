@extends('layouts.admin')

@section('content')
    <div class="max-w-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Header Section -->
        <div class="bg-white border-b border-gray-200 shadow-sm">
            <div class="px-6 py-4">
                <!-- Breadcrumb Navigation -->
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-blue-600 transition-all duration-200 hover:scale-105">
                                <i class="fas fa-home w-4 h-4 mr-2 text-gray-500"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-300 mx-2 text-xs"></i>
                                <span class="text-sm font-medium text-gray-700">Data Santri</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Page Title & Stats -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Data Santri</h1>
                        <p class="text-gray-600 text-sm">Kelola dan pantau data santri beserta informasi wali</p>
                    </div>
                    <div class="mt-4 lg:mt-0 flex items-center space-x-4">
                        <div class="bg-blue-50 px-4 py-2 rounded-lg border border-blue-100">
                            <span class="text-blue-600 font-semibold text-sm">Total: {{ count($santris) }} Santri</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-4">
            <!-- Search & Filter Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <!-- Search Bar -->
                        <div class="relative flex-1 max-w-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="searchInput"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                placeholder="Cari nama santri atau wali...">
                        </div>

                        <!-- Filter Options -->
                        <div class="flex items-center space-x-3">
                            <select id="statusFilter"
                                class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <option value="all">Semua Status</option>
                                <option value="active">Aktif</option>
                                <option value="inactive">Non Aktif</option>
                            </select>
                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                <i class="fas fa-info-circle text-gray-400"></i>
                                <span id="resultCounter">{{ count($santris) }} santri ditemukan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-table w-5 h-5 mr-3 text-gray-600"></i>
                        Daftar Santri
                    </h2>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-user w-4 h-4 text-gray-400"></i>
                                        <span>Nama Santri</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-envelope w-4 h-4 text-gray-400"></i>
                                        <span>Email Santri</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-user-friends w-4 h-4 text-gray-400"></i>
                                        <span>Nama Wali</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-at w-4 h-4 text-gray-400"></i>
                                        <span>Email Wali</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-wallet w-4 h-4 text-gray-400"></i>
                                        <span>Saldo</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-toggle-on w-4 h-4 text-gray-400"></i>
                                        <span>Status</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="santriTableBody">
                            @forelse ($santris as $index => $santri)
                                <tr class="hover:bg-gray-100 hover:border-l-4 hover:border-blue-500 transition-all duration-200 group santri-row"
                                    data-santri-name="{{ strtolower($santri->user->name ?? '') }}"
                                    data-wali-name="{{ strtolower($santri->wali->name ?? '') }}"
                                    data-santri-email="{{ strtolower($santri->user->email ?? '') }}"
                                    data-wali-email="{{ strtolower($santri->wali->email ?? '') }}"
                                    data-saldo="{{ $santri->saldo ?? 0 }}"
                                    data-status="{{ $santri->user->active ? 'active' : 'inactive' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                                    {{ strtoupper(substr($santri->user->name ?? 'N', 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ $santri->user->name ?? 'N/A' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    ID: {{ str_pad($santri->id, 4, '0', STR_PAD_LEFT) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $santri->user->email ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <div
                                                    class="h-8 w-8 rounded-full bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center text-white font-semibold text-xs">
                                                    {{ strtoupper(substr($santri->wali->name ?? 'N', 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $santri->wali->name ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $santri->wali->email ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-bold text-gray-900">
                                                Rp {{ number_format($santri->saldo ?? 0, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if ($santri->user->active)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle w-4 h-4 mr-1"></i>
                                                    Aktif
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle w-4 h-4 mr-1"></i>
                                                    Non Aktif
                                                </span>
                                            @endif
                                            <a href="{{ route('admin.santri.status.edit', $santri->id) }}"
                                                class="ml-2 text-blue-600 hover:text-blue-800 transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyState">
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data santri</h3>
                                            <p class="text-gray-500 text-sm">Belum ada santri yang terdaftar dalam sistem.
                                            </p>
                                            <button
                                                class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                                Tambah Santri Pertama
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            <!-- No Results Found State -->
                            <tr id="noResultsState" class="hidden">
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-search text-gray-300 text-4xl mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada hasil ditemukan</h3>
                                        <p class="text-gray-500 text-sm">Coba ubah kata kunci pencarian atau filter status.
                                        </p>
                                        <button id="clearSearch"
                                            class="mt-4 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                                            <i class="fas fa-times w-4 h-4 mr-2"></i>
                                            Hapus Pencarian
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                @if (count($santris) > 0)
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-600">
                                <span id="tableFooterCounter">Menampilkan {{ count($santris) }} dari
                                    {{ count($santris) }} data santri</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button
                                    class="px-3 py-1 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors disabled:opacity-50"
                                    disabled>
                                    Sebelumnya
                                    <i class="fas fa-chevron-left w-3 h-3 mr-1"></i>
                                </button>
                                <button
                                    class="px-3 py-1 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors disabled:opacity-50"
                                    disabled>
                                    Selanjutnya
                                    <i class="fas fa-chevron-right w-3 h-3 ml-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        /* Enhanced hover effects */
        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Smooth transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Enhanced button animations */
        button {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        button:hover {
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }

        /* Search highlighting */
        .highlight {
            background-color: #fef3c7;
            font-weight: 600;
            padding: 1px 2px;
            border-radius: 2px;
        }

        /* Smooth fade animations */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        .fade-out {
            animation: fadeOut 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }
    </style>

    <!-- Real-time Search & Filter JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const resultCounter = document.getElementById('resultCounter');
            const tableFooterCounter = document.getElementById('tableFooterCounter');
            const santriRows = document.querySelectorAll('.santri-row');
            const noResultsState = document.getElementById('noResultsState');
            const emptyState = document.getElementById('emptyState');
            const clearSearchBtn = document.getElementById('clearSearch');
            const totalSantri = {{ count($santris) }};

            // Function to perform search and filter
            function performSearch() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const selectedStatus = statusFilter.value;
                let visibleCount = 0;

                // Remove previous highlights
                removeHighlights();

                santriRows.forEach(row => {
                    const santriName = row.dataset.santriName;
                    const waliName = row.dataset.waliName;
                    const santriEmail = row.dataset.santriEmail;
                    const waliEmail = row.dataset.waliEmail;
                    const status = row.dataset.status;

                    // Check if row matches search term
                    const matchesSearch = searchTerm === '' ||
                        santriName.includes(searchTerm) ||
                        waliName.includes(searchTerm) ||
                        santriEmail.includes(searchTerm) ||
                        waliEmail.includes(searchTerm);

                    // Check if row matches status filter
                    const matchesStatus = selectedStatus === 'all' || status === selectedStatus;

                    // Show/hide row based on criteria
                    if (matchesSearch && matchesStatus) {
                        row.style.display = '';
                        row.classList.add('fade-in');
                        visibleCount++;

                        // Highlight search terms if search is active
                        if (searchTerm !== '') {
                            highlightText(row, searchTerm);
                        }
                    } else {
                        row.style.display = 'none';
                        row.classList.remove('fade-in');
                    }
                });

                // Update counters
                updateCounters(visibleCount);

                // Show/hide no results state
                toggleNoResultsState(visibleCount);
            }

            // Function to highlight search terms
            function highlightText(row, searchTerm) {
                const textElements = row.querySelectorAll('td .text-sm, td .text-xs');
                textElements.forEach(element => {
                    const originalText = element.textContent;
                    const regex = new RegExp(`(${escapeRegExp(searchTerm)})`, 'gi');

                    if (regex.test(originalText)) {
                        element.innerHTML = originalText.replace(regex,
                            '<span class="highlight">$1</span>');
                    }
                });
            }

            // Function to remove highlights
            function removeHighlights() {
                const highlights = document.querySelectorAll('.highlight');
                highlights.forEach(highlight => {
                    const parent = highlight.parentNode;
                    parent.replaceChild(document.createTextNode(highlight.textContent), highlight);
                    parent.normalize();
                });
            }

            // Function to escape special regex characters
            function escapeRegExp(string) {
                return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            }

            // Function to update counters
            function updateCounters(visibleCount) {
                const statusText = statusFilter.options[statusFilter.selectedIndex].text;
                const searchActive = searchInput.value.trim() !== '';

                if (searchActive || statusFilter.value !== 'all') {
                    resultCounter.textContent = `${visibleCount} santri ditemukan`;
                    tableFooterCounter.textContent = `Menampilkan ${visibleCount} dari ${totalSantri} data santri`;
                } else {
                    resultCounter.textContent = `${totalSantri} santri ditemukan`;
                    tableFooterCounter.textContent = `Menampilkan ${totalSantri} dari ${totalSantri} data santri`;
                }
            }

            // Function to toggle no results state
            function toggleNoResultsState(visibleCount) {
                if (visibleCount === 0 && totalSantri > 0) {
                    noResultsState.classList.remove('hidden');
                    if (emptyState) emptyState.style.display = 'none';
                } else {
                    noResultsState.classList.add('hidden');
                    if (emptyState && totalSantri === 0) emptyState.style.display = '';
                }
            }

            // Function to clear search and filters
            function clearSearch() {
                searchInput.value = '';
                statusFilter.value = 'all';
                removeHighlights();
                performSearch();
                searchInput.focus();
            }

            // Real-time search on input
            searchInput.addEventListener('input', function() {
                performSearch();
            });

            // Real-time filter on change
            statusFilter.addEventListener('change', function() {
                performSearch();
            });

            // Clear search button
            if (clearSearchBtn) {
                clearSearchBtn.addEventListener('click', clearSearch);
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + K to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    searchInput.focus();
                    searchInput.select();
                }

                // Escape to clear search
                if (e.key === 'Escape' && (searchInput === document.activeElement)) {
                    clearSearch();
                }
            });

            // Add search shortcut hint
            searchInput.placeholder = 'Cari nama santri atau wali... (Ctrl+K)';

            // Initialize with current state
            performSearch();
        });
    </script>
@endsection
