@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
<div class="container mx-auto">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Daftar Produk</h1>
            <p class="text-gray-600 mt-2">Kelola produk koperasi digital Anda</p>
        </div>
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
            <a href="{{ route('admin.product.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i>
                Tambah Produk
            </a>
            <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center">
                <i class="fas fa-filter mr-2"></i>
                Filter
            </button>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4">
            <div class="flex-1">
                <div class="relative">
                    <input type="text" 
                           id="searchInput"
                           placeholder="Cari produk..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <div class="flex space-x-3">
                <select id="categoryFilter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    @if($products->isNotEmpty())
                        @foreach($products->pluck('category')->unique() as $category)
                            <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                        @endforeach
                    @endif
                </select>
                <select id="sortBy" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="name">Nama A-Z</option>
                    <option value="price_low">Harga Terendah</option>
                    <option value="price_high">Harga Tertinggi</option>
                    <option value="stock">Stok Terbanyak</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Products Grid -->
    @if($products->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-box-open text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-3">Belum Ada Produk</h3>
                <p class="text-gray-500 mb-6">Mulai tambahkan produk pertama Anda untuk memulai penjualan di koperasi digital.</p>
                <a href="{{ route('admin.product.create') }}" 
                   class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Produk Pertama
                </a>
            </div>
        </div>
    @else
        <!-- Products Grid -->
        <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="product-card bg-white rounded-lg shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200" 
                     data-name="{{ strtolower($product->name) }}" 
                     data-category="{{ strtolower($product->category) }}"
                     data-price="{{ $product->price }}"
                     data-stock="{{ $product->stock }}">
                    
                    <!-- Product Image -->
                    <div class="relative overflow-hidden bg-gray-100 h-48 flex items-center justify-center">
                        @if(isset($product->image) && $product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                <i class="fas fa-image text-4xl text-gray-400"></i>
                            </div>
                        @endif
                        
                        <!-- Stock Badge -->
                        @if($product->stock <= 5)
                            <div class="absolute top-2 left-2">
                                @if($product->stock == 0)
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">Stok Habis</span>
                                @else
                                    <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded-full">Stok Terbatas</span>
                                @endif
                            </div>
                        @endif

                        <!-- Quick Actions -->
                        <div class="absolute top-2 right-2 flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.product.edit', $product) }}" 
                               class="bg-white text-gray-600 hover:text-blue-600 p-2 rounded-full shadow-md transition-colors">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form action="{{ route('admin.product.destroy', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"
                                        class="bg-white text-gray-600 hover:text-red-600 p-2 rounded-full shadow-md transition-colors">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <!-- Category -->
                        <div class="mb-2">
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                {{ ucfirst($product->category) }}
                            </span>
                        </div>

                        <!-- Product Name -->
                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-blue-600 transition-colors">
                            {{ $product->name }}
                        </h3>

                        <!-- Price -->
                        <div class="mb-3">
                            <span class="text-lg font-bold text-blue-600">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Stock Info -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-box mr-1"></i>
                                <span>Stok: {{ $product->stock }}</span>
                            </div>
                            @if($product->stock > 0)
                                <span class="text-green-600 text-sm font-medium">Tersedia</span>
                            @else
                                <span class="text-red-600 text-sm font-medium">Habis</span>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" 
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white py-2 px-3 rounded-lg transition-colors duration-200 flex items-center justify-center text-sm font-medium"
                                    {{ $product->stock == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-shopping-cart mr-2"></i>
                                @if($product->stock == 0)
                                    Stok Habis
                                @else
                                    Keranjang
                                @endif
                            </button>
                            <a href="{{ route('admin.product.show', $product) }}" 
                               class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-3 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Load More or Pagination (if needed) -->
        <div class="mt-8 text-center">
            <button id="loadMore" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg transition-colors duration-200" style="display: none;">
                Tampilkan Lebih Banyak
            </button>
        </div>
    @endif
</div>

<!-- Shopping Cart Toast Notification -->
<div id="cartToast" class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full opacity-0 transition-all duration-300 z-50">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span id="cartToastMessage">Produk ditambahkan ke keranjang!</span>
    </div>
</div>

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
    
    .product-card:hover .group-hover\:opacity-100 {
        opacity: 1;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const sortBy = document.getElementById('sortBy');
    const productsGrid = document.getElementById('productsGrid');
    const productCards = document.querySelectorAll('.product-card');

    // Search and filter function
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

        // Sort visible cards
        visibleCards.sort((a, b) => {
            switch(sortValue) {
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

        // Reorder DOM elements
        visibleCards.forEach(card => {
            productsGrid.appendChild(card);
        });
    }

    // Event listeners
    searchInput.addEventListener('input', filterProducts);
    categoryFilter.addEventListener('change', filterProducts);
    sortBy.addEventListener('change', filterProducts);
});

// Add to cart function
function addToCart(productId, productName, productPrice) {
    // Here you would typically make an AJAX request to add the item to cart
    // For now, we'll just show a toast notification
    
    const toast = document.getElementById('cartToast');
    const message = document.getElementById('cartToastMessage');
    
    message.textContent = `${productName} ditambahkan ke keranjang!`;
    
    // Show toast
    toast.classList.remove('translate-x-full', 'opacity-0');
    toast.classList.add('translate-x-0', 'opacity-100');
    
    // Hide toast after 3 seconds
    setTimeout(() => {
        toast.classList.remove('translate-x-0', 'opacity-100');
        toast.classList.add('translate-x-full', 'opacity-0');
    }, 3000);
    
    // You can add AJAX call here to actually add to cart
    // Example:
    /*
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart counter, etc.
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
    */
}

// Auto-dismiss alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('[role="alert"]');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});
</script>
@endsection