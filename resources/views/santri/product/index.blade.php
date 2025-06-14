@extends('layouts.santri')

@section('title', 'Daftar Produk')

@section('content')
    <div class="container mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Daftar Produk</h1>
                <p class="text-gray-600 mt-2">Lihat daftar produk koperasi digital</p>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Cari produk..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <select id="categoryFilter"
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Kategori</option>
                        @if ($products->isNotEmpty())
                            @foreach ($products->pluck('category')->unique() as $category)
                                <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                            @endforeach
                        @endif
                    </select>
                    <select id="sortBy"
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="name">Nama A-Z</option>
                        <option value="price_low">Harga Terendah</option>
                        <option value="price_high">Harga Tertinggi</option>
                        <option value="stock">Stok Terbanyak</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        @if ($products->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-box-open text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Belum Ada Produk</h3>
                    <p class="text-gray-500 mb-6">Tidak ada produk yang tersedia saat ini.</p>
                </div>
            </div>
        @else
            <div id="productsGrid"
                class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach ($products as $product)
                    <div class="product-card bg-white rounded-lg shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200"
                        data-name="{{ strtolower($product->name) }}" data-category="{{ strtolower($product->category) }}"
                        data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden bg-gray-100 h-36 flex items-center justify-center">
                            @if (isset($product->image) && $product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="max-w-full max-h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                    <i class="fas fa-image text-3xl text-gray-400"></i>
                                </div>
                            @endif
                            <!-- Stock Badge -->
                            @if ($product->stock <= 5)
                                <div class="absolute top-2 left-2">
                                    @if ($product->stock == 0)
                                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">Stok Habis</span>
                                    @else
                                        <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded-full">Stok
                                            Terbatas</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-3">
                            <!-- Category -->
                            <div class="mb-1">
                                <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                    {{ ucfirst($product->category) }}
                                </span>
                            </div>

                            <!-- Product Name -->
                            <h3
                                class="font-semibold text-gray-800 mb-1 line-clamp-2 hover:text-blue-600 transition-colors text-sm">
                                {{ $product->name }}
                            </h3>

                            <!-- Price -->
                            <div class="mb-2">
                                <span class="text-base font-bold text-blue-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Stock Info -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-xs text-gray-500">
                                    <i class="fas fa-box mr-1"></i>
                                    <span>Stok: {{ $product->stock }}</span>
                                </div>
                                @if ($product->stock > 0)
                                    <span class="text-green-600 text-xs font-medium">Tersedia</span>
                                @else
                                    <span class="text-red-600 text-xs font-medium">Habis</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const sortBy = document.getElementById('sortBy');
            const productsGrid = document.getElementById('productsGrid');
            const productCards = document.querySelectorAll('.product-card');

            function filterProducts() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedCategory = categoryFilter.value.toLowerCase();
                const sortValue = sortBy.value;

                let visibleCards = Array.from(productCards).filter(card => {
                    const name = card.dataset.name;
                    const category = card.dataset.category;

                    const matchesSearch = name.includes(searchTerm);
                    const matchesCategory = !selectedCategory || category === selectedCategory;

                    if (matchesSearch && matchesCategory) {
                        card.style.display = 'block';
                        return true;
                    } else {
                        card.style.display = 'none';
                        return false;
                    }
                });

                visibleCards.sort((a, b) => {
                    switch (sortValue) {
                        case 'name':
                            return a.dataset.name.localeCompare(b.dataset.name);
                        case 'price_low':
                            return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                        case 'price_high':
                            return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                        case 'stock':
                            return parseInt(b.dataset.stock) - parseInt(a.dataset.stock);
                        default:
                            return 0;
                    }
                });

                visibleCards.forEach(card => {
                    productsGrid.appendChild(card);
                });
            }

            searchInput.addEventListener('input', filterProducts);
            categoryFilter.addEventListener('change', filterProducts);
            sortBy.addEventListener('change', filterProducts);
        });
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection
