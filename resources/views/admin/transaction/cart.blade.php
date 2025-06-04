@extends('layouts.admin')

@section('title', 'Transaksi')

@section('content')
    <!-- Flash Message Container -->
    <div id="flash-message-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-[calc(100vh-8rem)]">
        <!-- Left Side - Products Grid -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-4 overflow-y-auto">
            <div class="mb-4">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Daftar Produk</h2>
                <div class="relative">
                    <input type="text" id="searchProduct" placeholder="Cari produk..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            @if ($products->isEmpty())
                <div class="col-span-full flex flex-col items-center justify-center py-16">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-box-open text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Produk</h3>
                    <p class="text-gray-500 mb-4 text-center max-w-xs">Produk belum tersedia di sistem. Silakan tambahkan
                        produk baru untuk mulai bertransaksi.</p>
                    <a href="{{ route('admin.product.create') }}"
                        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200 shadow">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Produk Baru
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3" id="products-grid">
                    @foreach ($products as $product)
                        <div
                            class="product-card group bg-white border border-gray-200 shadow-xl rounded-lg p-3 cursor-pointer relative overflow-hidden hover:shadow-2xl transition-all duration-600">
                            <div
                                class="aspect-square bg-gray-50 rounded-lg mb-2 flex items-center justify-center overflow-hidden relative">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover rounded">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-xl"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-2">
                                <h3 class="text-xs font-medium text-gray-800 mb-1 line-clamp-2 leading-tight">
                                    {{ $product->name }}</h3>
                                <p class="text-xs text-blue-600 font-semibold mb-1">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">Stok: {{ $product->stock }}</p>
                                <span
                                    class="inline-block px-2 py-1 text-xs rounded-full 
                            {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </div>

                            @if ($product->status === 'active' && $product->stock > 0)
                                <button
                                    onclick="addToCart('{{ $product->id }}', '{{ htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8') }}', {{ is_numeric($product->price) ? $product->price : 0 }}, {{ is_numeric($product->stock) ? $product->stock : 0 }})"
                                    class="absolute bottom-2 right-2 w-7 h-7 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-shopping-cart text-xs"></i>
                                </button>
                            @else
                                <div
                                    class="absolute bottom-2 right-2 w-7 h-7 bg-gray-400 text-white rounded-full flex items-center justify-center cursor-not-allowed">
                                    <i class="fas fa-ban text-xs"></i>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Side - Transaction Area -->
        <div class="bg-white rounded-lg shadow-sm p-4 overflow-y-auto">
            <!-- Header -->
            <div class="border-b pb-4 mb-4">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Transaksi</h2>

                <!-- Santri Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Santri</label>
                    <select id="santri_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Santri (opsional untuk non-santri) --</option>
                        @foreach ($santris as $santri)
                            <option value="{{ $santri->id }}">{{ $santri->name }} - Saldo: Rp
                                {{ number_format($santri->saldo, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Payment Method -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                    <select id="payment_type"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="saldo">💳 Saldo Digital</option>
                        <option value="cash">💵 Tunai</option>
                    </select>
                </div>
            </div>

            <!-- Cart Items -->
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-sm font-medium text-gray-700">Keranjang Belanja</h3>
                    <button onclick="clearCart()" id="clear-cart-btn" style="display: none;"
                        class="text-xs text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-2 py-1 rounded transition-colors">
                        <i class="fas fa-trash mr-1"></i>
                        Kosongkan
                    </button>
                </div>
                <div class="space-y-3" id="cart-items">
                    <div class="text-center text-gray-500 text-sm py-4" id="empty-cart">
                        <i class="fas fa-shopping-cart text-2xl mb-2 opacity-50"></i>
                        <p>Keranjang masih kosong</p>
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="border-t pt-4">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Pajak (10%)</span>
                        <span id="tax">Rp 0</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-2">
                        <span>Total</span>
                        <span id="total">Rp 0</span>
                    </div>
                </div>

                <!-- Pay Button -->
                <button onclick="processPayment()" id="pay-button" disabled
                    class="w-full bg-gray-400 text-white py-3 rounded-lg mt-4 font-semibold transition-colors flex items-center justify-center gap-2 disabled:cursor-not-allowed">
                    <i class="fas fa-credit-card"></i>
                    <span>Bayar</span>
                    <span id="pay-amount">Rp 0</span>
                </button>
            </div>
        </div>
    </div>

    <style>
        .product-card {
            transition: box-shadow 0.3s ease;
        }

        .cart-item {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple 0.6s linear;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Flash Message Styles */
        .flash-message {
            max-width: 420px;
            transform: translateX(100%);
            opacity: 0;
            animation: slideInFlash 0.5s ease-out forwards;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
        }

        .flash-message.removing {
            animation: slideOutFlash 0.3s ease-in forwards;
        }

        @keyframes slideInFlash {
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutFlash {
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .flash-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.8));
            border-radius: 0 0 12px 12px;
            animation: progress 5s linear forwards;
        }

        @keyframes progress {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        .flash-icon {
            animation: bounce 1s ease-in-out;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }
    </style>

    <script>
        let cart = [];

        // Flash Message Function
        function showFlashMessage(type, title, message, icon = null) {
            const container = document.getElementById('flash-message-container');

            const configs = {
                success: {
                    bgColor: 'bg-gradient-to-r from-green-500 to-emerald-600',
                    textColor: 'text-white',
                    icon: icon || 'fas fa-check-circle'
                },
                error: {
                    bgColor: 'bg-gradient-to-r from-red-500 to-red-600',
                    textColor: 'text-white',
                    icon: icon || 'fas fa-exclamation-circle'
                },
                warning: {
                    bgColor: 'bg-gradient-to-r from-yellow-500 to-orange-500',
                    textColor: 'text-white',
                    icon: icon || 'fas fa-exclamation-triangle'
                },
                info: {
                    bgColor: 'bg-gradient-to-r from-blue-500 to-blue-600',
                    textColor: 'text-white',
                    icon: icon || 'fas fa-info-circle'
                }
            };

            const config = configs[type] || configs.info;

            const flashDiv = document.createElement('div');
            flashDiv.className =
                `flash-message relative ${config.bgColor} ${config.textColor} p-4 rounded-lg shadow-lg border-l-4 border-white`;

            flashDiv.innerHTML = `
        <div class="flex items-start gap-3">
            <div class="flash-icon flex-shrink-0">
                <i class="${config.icon} text-xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-lg mb-1">${title}</div>
                <div class="text-sm opacity-90 leading-relaxed">${message}</div>
            </div>
            <button onclick="removeFlashMessage(this)" class="flex-shrink-0 ml-2 hover:bg-white hover:bg-opacity-20 rounded-full p-1 transition-colors">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
        <div class="flash-progress"></div>
    `;

            container.appendChild(flashDiv);

            setTimeout(() => {
                if (flashDiv.parentNode) {
                    removeFlashMessage(flashDiv.querySelector('button'));
                }
            }, 5000);
        }

        function removeFlashMessage(button) {
            const flashMessage = button.closest('.flash-message');
            flashMessage.classList.add('removing');
            setTimeout(() => {
                if (flashMessage.parentNode) {
                    flashMessage.remove();
                }
            }, 300);
        }

        // Confirm Dialog Function
        function showConfirmDialog(title, message, onConfirm, onCancel = null) {
            const backdrop = document.createElement('div');
            backdrop.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
            backdrop.style.animation = 'fadeIn 0.3s ease-out';

            const dialog = document.createElement('div');
            dialog.className = 'bg-white rounded-lg shadow-xl max-w-md w-full transform';
            dialog.style.animation = 'scaleIn 0.3s ease-out';

            dialog.innerHTML = `
        <div class="p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-question-circle text-orange-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">${title}</h3>
                    <p class="text-sm text-gray-600 mt-1">${message}</p>
                </div>
            </div>
            <div class="flex gap-3 justify-end">
                <button id="cancel-btn" class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors font-medium">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button id="confirm-btn" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-medium">
                    <i class="fas fa-check mr-2"></i>Ya, Kosongkan
                </button>
            </div>
        </div>
    `;

            backdrop.appendChild(dialog);
            document.body.appendChild(backdrop);

            const style = document.createElement('style');
            style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        @keyframes scaleOut {
            from { opacity: 1; transform: scale(1); }
            to { opacity: 0; transform: scale(0.9); }
        }
    `;
            document.head.appendChild(style);

            dialog.querySelector('#confirm-btn').onclick = () => {
                backdrop.style.animation = 'fadeOut 0.3s ease-in';
                dialog.style.animation = 'scaleOut 0.3s ease-in';
                setTimeout(() => {
                    document.body.removeChild(backdrop);
                    document.head.removeChild(style);
                }, 300);
                if (onConfirm) onConfirm();
            };

            const cancelHandler = () => {
                backdrop.style.animation = 'fadeOut 0.3s ease-in';
                dialog.style.animation = 'scaleOut 0.3s ease-in';
                setTimeout(() => {
                    document.body.removeChild(backdrop);
                    document.head.removeChild(style);
                }, 300);
                if (onCancel) onCancel();
            };

            dialog.querySelector('#cancel-btn').onclick = cancelHandler;
            backdrop.onclick = (e) => {
                if (e.target === backdrop) cancelHandler();
            };

            const escHandler = (e) => {
                if (e.key === 'Escape') {
                    cancelHandler();
                    document.removeEventListener('keydown', escHandler);
                }
            };
            document.addEventListener('keydown', escHandler);
        }

        // Add item to cart
        function addToCart(id, name, price, stock) {
            console.log('addToCart called:', {
                id,
                name,
                price,
                stock
            });

            const button = event.target.closest('button');
            if (button) {
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                const rect = button.getBoundingClientRect();
                const size = 50;
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = (event.clientX - rect.left - size / 2) + 'px';
                ripple.style.top = (event.clientY - rect.top - size / 2) + 'px';
                ripple.style.position = 'absolute';
                button.appendChild(ripple);

                setTimeout(() => ripple.remove(), 600);
            }

            const existingItem = cart.find(item => item.id === id);

            if (existingItem) {
                if (existingItem.qty < stock) {
                    existingItem.qty += 1;
                } else {
                    showFlashMessage('warning', 'Stok Terbatas!',
                        'Jumlah produk dalam keranjang sudah mencapai batas stok yang tersedia.',
                        'fas fa-exclamation-triangle');
                    return;
                }
            } else {
                cart.push({
                    id,
                    name,
                    price,
                    qty: 1,
                    stock
                });
            }

            updateCartDisplay();
            syncCartWithBackend();
        }

        // Remove item from cart
        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            updateCartDisplay();
            syncCartWithBackend();
        }

        // Clear entire cart
        function clearCart() {
            showConfirmDialog(
                'Kosongkan Keranjang?',
                'Apakah Anda yakin ingin menghapus semua produk dari keranjang belanja?',
                () => {
                    cart = [];
                    updateCartDisplay();
                    syncCartWithBackend();
                    showFlashMessage('info', 'Keranjang Dikosongkan',
                        'Semua produk telah dihapus dari keranjang belanja.', 'fas fa-shopping-cart');
                }
            );
        }

        // Update item quantity
        function updateQuantity(id, change) {
            const item = cart.find(item => item.id === id);
            if (item) {
                const newQty = item.qty + change;
                if (newQty <= 0) {
                    removeFromCart(id);
                } else if (newQty <= item.stock) {
                    item.qty = newQty;
                    updateCartDisplay();
                    syncCartWithBackend();
                } else {
                    showFlashMessage('warning', 'Stok Terbatas!', `Stok ${item.name} hanya tersedia ${item.stock} unit.`,
                        'fas fa-exclamation-triangle');
                }
            }
        }

        // Update cart UI
        function updateCartDisplay() {
            const cartItemsContainer = document.getElementById('cart-items');
            const emptyCart = document.getElementById('empty-cart');
            const payButton = document.getElementById('pay-button');
            const clearCartBtn = document.getElementById('clear-cart-btn');

            if (cart.length === 0) {
                emptyCart.style.display = 'block';
                payButton.disabled = true;
                payButton.classList.replace('bg-blue-600', 'bg-gray-400');
                payButton.classList.remove('hover:bg-blue-700');
                clearCartBtn.style.display = 'none';
            } else {
                emptyCart.style.display = 'none';
                payButton.disabled = false;
                payButton.classList.replace('bg-gray-400', 'bg-blue-600');
                payButton.classList.add('hover:bg-blue-700');
                clearCartBtn.style.display = 'block';
            }

            cartItemsContainer.querySelectorAll('.cart-item').forEach(item => item.remove());

            let subtotal = 0;

            cart.forEach(item => {
                const itemTotal = item.price * item.qty;
                subtotal += itemTotal;

                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item flex items-center gap-3 p-3 bg-gray-50 rounded-lg';
                cartItem.innerHTML = `
            <div class="flex-1">
                <h4 class="font-medium text-sm text-gray-800 line-clamp-2">${item.name}</h4>
                <div class="flex items-center justify-between mt-1">
                    <span class="text-xs text-gray-500">Rp ${parseInt(item.price).toLocaleString('id-ID')}</span>
                    <div class="flex items-center gap-2">
                        <button onclick="updateQuantity('${item.id}', -1)" class="w-6 h-6 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-xs hover:bg-red-200">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="text-sm font-medium w-8 text-center">${item.qty}</span>
                        <button onclick="updateQuantity('${item.id}', 1)" class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs hover:bg-green-200">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm font-bold text-gray-800">Rp ${itemTotal.toLocaleString('id-ID')}</div>
                <button onclick="removeFromCart('${item.id}')" class="text-red-500 hover:text-red-700 text-xs mt-1">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
                cartItemsContainer.appendChild(cartItem);
            });

            const tax = subtotal * 0.1;
            const total = subtotal + tax;

            document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            document.getElementById('tax').textContent = `Rp ${Math.round(tax).toLocaleString('id-ID')}`;
            document.getElementById('total').textContent = `Rp ${Math.round(total).toLocaleString('id-ID')}`;
            document.getElementById('pay-amount').textContent = `Rp ${Math.round(total).toLocaleString('id-ID')}`;
        }

        // Process payment with AJAX
        function processPayment() {
            if (cart.length === 0) {
                showFlashMessage('warning', 'Keranjang Kosong!', 'Silakan tambahkan produk ke keranjang terlebih dahulu.',
                    'fas fa-shopping-cart');
                return;
            }

            const santriId = document.getElementById('santri_id').value;
            const paymentType = document.getElementById('payment_type').value;

            if (paymentType === 'saldo' && !santriId) {
                showFlashMessage('warning', 'Pilih Santri!',
                    'Silakan pilih santri terlebih dahulu untuk pembayaran menggunakan saldo.', 'fas fa-user');
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                showFlashMessage('error', 'Kesalahan Konfigurasi',
                    'Token CSRF tidak ditemukan. Silakan muat ulang halaman.', 'fas fa-bug');
                return;
            }

            const payButton = document.getElementById('pay-button');
            const originalContent = payButton.innerHTML;
            payButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            payButton.disabled = true;

            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
            const tax = subtotal * 0.1;
            const total = subtotal + tax;

            const transactionData = {
                santri_id: santriId || null,
                payment_type: paymentType,
                source: 'transaction',
                items: cart.map(item => ({
                    id: item.id,
                    qty: item.qty
                })),
                subtotal: subtotal,
                tax: tax,
                total: total,
                _token: csrfToken
            };

            fetch('{{ route('admin.admin.transaction.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(transactionData)
                })
                .then(response => {
                    console.log('Store response:', response);
                    return response.json();
                })
                .then(data => {
                    payButton.innerHTML = originalContent;
                    payButton.disabled = false;

                    if (data.success) {
                        const santriName = santriId ? document.getElementById('santri_id').selectedOptions[0].text
                            .split(' - ')[0] : 'Non-Santri';
                        const paymentMethod = paymentType === 'saldo' ? 'Saldo Digital' : 'Tunai';

                        showFlashMessage('success',
                            'Transaksi Berhasil! 🎉',
                            `ID Transaksi: <strong>${data.transaction_id}</strong><br>
                 Pembeli: ${santriName}<br>
                 Metode: ${paymentMethod}<br>
                 Total: Rp ${Math.round(total).toLocaleString('id-ID')}`,
                            'fas fa-check-circle'
                        );

                        cart = [];
                        updateCartDisplay();
                        syncCartWithBackend();

                        document.getElementById('santri_id').value = '';
                    } else {
                        showFlashMessage('error',
                            'Transaksi Gagal!',
                            data.message || 'Terjadi kesalahan saat memproses transaksi. Silakan coba lagi.',
                            'fas fa-times-circle'
                        );
                    }
                })
                .catch(error => {
                    payButton.innerHTML = originalContent;
                    payButton.disabled = false;

                    console.error('Store error:', error);
                    showFlashMessage('error',
                        'Kesalahan Sistem!',
                        'Terjadi kesalahan teknis saat memproses transaksi. Silakan hubungi administrator.',
                        'fas fa-bug'
                    );
                });
        }

        // Sync cart with backend
        function syncCartWithBackend() {
            if (cart.length === 0) {
                console.log('Cart is empty, no need to sync');
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                console.error('CSRF token not found');
                return;
            }

            console.log('Syncing cart:', cart);
            fetch('{{ route('admin.admin.transaction.syncCart') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        items: cart
                    })
                })
                .then(response => {
                    console.log('Sync response:', response);
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        console.error('Cart sync failed:', data.message);
                    } else {
                        console.log('Cart synced successfully');
                    }
                })
                .catch(error => console.error('Sync error:', error));
        }

        // Search products
        document.getElementById('searchProduct').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            document.querySelectorAll('.product-card').forEach(card => {
                const productName = card.querySelector('h3').textContent.toLowerCase();
                card.style.display = productName.includes(searchTerm) ? 'block' : 'none';
            });
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateCartDisplay();
        });
    </script>
@endsection
