@extends('../layouts.admin')

@section('title', 'Edit Produk')

@section('content')
    <div class="container mx-auto max-w-4xl">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.product.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                        <i class="fas fa-box mr-2"></i>
                        Produk
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">Edit Produk</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="bg-orange-100 p-2 rounded-lg">
                            <i class="fas fa-edit text-orange-600 text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Edit Produk</h1>
                            <p class="text-gray-600 mt-1">Ubah informasi produk {{ $product->name }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.product.index') }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div class="px-6 py-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column - Product Image -->
                        <div class="lg:col-span-1">
                            <div class="sticky top-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-image mr-2 text-orange-600"></i>
                                    Gambar Produk
                                </h3>

                                <!-- Image Upload Area -->
                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-orange-400 transition-colors">
                                    <div id="imagePreview" class="{{ $product->image ? '' : 'hidden' }}">
                                        <img id="previewImg"
                                            src="{{ $product->image ? asset('storage/' . $product->image) : '' }}"
                                            alt="Preview" class="max-w-full h-48 object-cover rounded-lg mx-auto mb-4">
                                        <input type="hidden" name="delete_image" id="delete_image" value="0">
                                        <button type="button" onclick="removeImage()"
                                            class="text-red-600 hover:text-red-700 text-sm">
                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus Gambar
                                        </button>
                                    </div>

                                    <div id="uploadArea" class="{{ $product->image ? 'hidden' : '' }}">
                                        <div
                                            class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-cloud-upload-alt text-2xl text-gray-400"></i>
                                        </div>
                                        <h4 class="text-lg font-medium text-gray-700 mb-2">Upload Gambar Produk</h4>
                                        <p class="text-sm text-gray-500 mb-4">PNG, JPG hingga 2MB</p>
                                        <label for="image"
                                            class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg cursor-pointer transition-colors inline-block">
                                            <i class="fas fa-plus mr-2"></i>
                                            Pilih Gambar
                                        </label>
                                    </div>

                                    <input type="file" id="image" name="image" accept="image/*" class="hidden"
                                        onchange="previewImage(this)">
                                </div>

                                @error('image')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <!-- Current Image Info -->
                                @if ($product->image)
                                    <div class="mt-4 bg-green-50 border border-green-200 rounded-lg p-4">
                                        <h4 class="text-sm font-medium text-green-800 mb-2">Gambar Saat Ini:</h4>
                                        <p class="text-xs text-green-700">{{ basename($product->image) }}</p>
                                        <p class="text-xs text-green-600 mt-1">Biarkan kosong jika tidak ingin mengubah
                                            gambar</p>
                                    </div>
                                @endif

                                <!-- Upload Tips -->
                                <div class="mt-4 bg-orange-50 border border-orange-200 rounded-lg p-4">
                                    <h4 class="text-sm font-medium text-orange-800 mb-2">Tips Upload Gambar:</h4>
                                    <ul class="text-xs text-orange-700 space-y-1">
                                        <li>• Gunakan gambar dengan rasio 1:1 untuk hasil terbaik</li>
                                        <li>• Ukuran minimum 300x300 pixel</li>
                                        <li>• Format yang didukung: JPG, PNG</li>
                                        <li>• Maksimal ukuran file 2MB</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Product Details -->
                        <div class="lg:col-span-2 space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-orange-600"></i>
                                Informasi Produk
                            </h3>

                            <!-- Product Name -->
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Nama Produk <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', $product->name) }}" placeholder="Masukkan nama produk..."
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror">
                                    <i class="fas fa-tag absolute left-3 top-4 text-gray-400"></i>
                                </div>
                                @error('name')
                                    <p class="text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="space-y-2">
                                <label for="category" class="block text-sm font-medium text-gray-700">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="category" name="category"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent appearance-none bg-white transition-all @error('category') border-red-500 @enderror">
                                        <option value="">Pilih Kategori</option>
                                        <option value="makanan"
                                            {{ old('category', $product->category) == 'makanan' ? 'selected' : '' }}>
                                            Makanan</option>
                                        <option value="minuman"
                                            {{ old('category', $product->category) == 'minuman' ? 'selected' : '' }}>
                                            Minuman</option>
                                        <option value="snack"
                                            {{ old('category', $product->category) == 'snack' ? 'selected' : '' }}>Snack
                                        </option>
                                        <option value="kebutuhan_harian"
                                            {{ old('category', $product->category) == 'kebutuhan_harian' ? 'selected' : '' }}>
                                            Kebutuhan Harian</option>
                                        <option value="alat_tulis"
                                            {{ old('category', $product->category) == 'alat_tulis' ? 'selected' : '' }}>
                                            Alat Tulis</option>
                                        <option value="lainnya"
                                            {{ old('category', $product->category) == 'lainnya' ? 'selected' : '' }}>
                                            Lainnya</option>
                                    </select>
                                    <i class="fas fa-list-alt absolute left-3 top-4 text-gray-400"></i>
                                    <i class="fas fa-chevron-down absolute right-3 top-4 text-gray-400"></i>
                                </div>
                                @error('category')
                                    <p class="text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Price and Stock -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Price -->
                                <div class="space-y-2">
                                    <label for="price" class="block text-sm font-medium text-gray-700">
                                        Harga <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="price" name="price"
                                            value="{{ old('price', $product->price) }}" placeholder="0" min="0"
                                            step="0.01"
                                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('price') border-red-500 @enderror">
                                        <span class="absolute left-3 top-3 text-gray-500 font-medium">Rp</span>
                                    </div>
                                    @error('price')
                                        <p class="text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Stock -->
                                <div class="space-y-2">
                                    <label for="stock" class="block text-sm font-medium text-gray-700">
                                        Stok <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="stock" name="stock"
                                            value="{{ old('stock', $product->stock) }}" placeholder="0" min="0"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('stock') border-red-500 @enderror">
                                        <i class="fas fa-boxes absolute left-3 top-4 text-gray-400"></i>
                                    </div>
                                    @error('stock')
                                        <p class="text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description (Optional) -->
                            <div class="space-y-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">
                                    Deskripsi Produk <span class="text-gray-400">(Opsional)</span>
                                </label>
                                <div class="relative">
                                    <textarea id="description" name="description" rows="4" placeholder="Masukkan deskripsi produk..."
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all resize-none">{{ old('description', $product->description) }}</textarea>
                                    <i class="fas fa-align-left absolute left-3 top-4 text-gray-400"></i>
                                </div>
                                <p class="text-xs text-gray-500">Maksimal 500 karakter</p>
                            </div>

                            <!-- Product Status -->
                            <div class="space-y-3">
                                <label class="block text-sm font-medium text-gray-700">Status Produk</label>
                                <div class="flex items-center space-x-6">
                                    <label class="flex items-center">
                                        <input type="radio" name="status" value="active"
                                            {{ old('status', $product->status) == 'active' ? 'checked' : '' }}
                                            class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                                        <span class="ml-2 text-sm text-gray-700">Aktif</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="status" value="inactive"
                                            {{ old('status', $product->status) == 'inactive' ? 'checked' : '' }}
                                            class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                                        <span class="ml-2 text-sm text-gray-700">Tidak Aktif</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Field yang bertanda <span class="text-red-500">*</span> wajib diisi
                        </div>
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                            <button type="button" onclick="resetForm()"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg transition-colors flex items-center justify-center">
                                <i class="fas fa-undo mr-2"></i>
                                Reset Form
                            </button>
                            <button type="submit"
                                class="bg-orange-600 hover:bg-orange-800 text-white px-8 py-3 rounded-lg transition-colors flex items-center justify-center font-medium">
                                <i class="fas fa-save mr-2"></i>
                                Update Produk
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-6 bg-orange-50 border border-orange-200 rounded-lg p-6">
            <h4 class="text-lg font-semibold text-orange-800 mb-3 flex items-center">
                <i class="fas fa-lightbulb mr-2"></i>
                Tips Mengedit Produk
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h5 class="font-medium text-orange-700 mb-2">Perubahan Data:</h5>
                    <ul class="text-sm text-orange-600 space-y-1">
                        <li>• Periksa kembali data sebelum menyimpan</li>
                        <li>• Pastikan harga dan stok sudah benar</li>
                        <li>• Gambar lama akan diganti jika upload gambar baru</li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-medium text-orange-700 mb-2">Status Produk:</h5>
                    <ul class="text-sm text-orange-600 space-y-1">
                        <li>• Status "Tidak Aktif" akan menyembunyikan produk</li>
                        <li>• Produk tidak aktif tidak bisa dibeli customer</li>
                        <li>• Ubah ke "Aktif" untuk menampilkan kembali</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom styles for enhanced form */
        .form-floating {
            position: relative;
        }

        .form-floating input:focus+label,
        .form-floating input:not(:placeholder-shown)+label {
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
            color: #ea580c;
        }

        /* Custom file upload styles */
        #image::-webkit-file-upload-button {
            visibility: hidden;
        }

        /* Smooth transitions */
        input,
        select,
        textarea {
            transition: all 0.2s ease-in-out;
        }

        input:focus,
        select:focus,
        textarea:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(234, 88, 12, 0.15);
        }

        /* Loading state for submit button */
        button[type="submit"]:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Validation styles */
        .error-input {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }
    </style>

    <script>
        // Store original values for reset functionality
        const originalValues = {
            name: '{{ $product->name }}',
            category: '{{ $product->category }}',
            price: '{{ $product->price }}',
            stock: '{{ $product->stock }}',
            description: '{{ $product->description ?? '' }}',
            status: '{{ $product->status }}',
            image: '{{ $product->image ? asset('storage/' . $product->image) : '' }}'
        };

        // Image preview functionality
        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                    document.getElementById('uploadArea').classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
            document.getElementById('uploadArea').classList.remove('hidden');

            // Add hidden input for delete_image flag
            let deleteImageInput = document.querySelector('input[name="delete_image"]');
            if (!deleteImageInput) {
                deleteImageInput = document.createElement('input');
                deleteImageInput.type = 'hidden';
                deleteImageInput.name = 'delete_image';
                deleteImageInput.value = '1';
                document.querySelector('form').appendChild(deleteImageInput);
            } else {
                deleteImageInput.value = '1';
            }
        }

        // Form validation and enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.querySelector('button[type="submit"]');
            const inputs = document.querySelectorAll('input[required], select[required]');

            // Real-time validation
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    clearErrors(this);
                });
            });

            // Form submission with loading state
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default to handle confirmation first
                showConfirmDialog(
                    'Konfirmasi Update',
                    'Apakah Anda yakin ingin mengupdate produk ini? Perubahan tidak bisa dibatalkan.',
                    function() { // On confirm
                        let isValid = true;
                        inputs.forEach(input => {
                            if (!validateField(input)) {
                                isValid = false;
                            }
                        });
                        if (isValid) {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML =
                                '<i class="fas fa-spinner fa-spin mr-2"></i>Mengupdate...';
                            form.submit(); // Submit the form
                        }
                    },
                    function() { // On cancel, do nothing or show a message
                        // Optionally: console.log('Update cancelled');
                    }
                );
            });

            // Price formatting
            const priceInput = document.getElementById('price');
            priceInput.addEventListener('input', function() {
                let value = this.value.replace(/[^\d.]/g, '');
                if (value) {
                    // Simple number formatting
                    this.value = value;
                }
            });
        });

        function validateField(field) {
            const value = field.value.trim();
            const fieldName = field.name;

            clearErrors(field);

            if (field.hasAttribute('required') && !value) {
                showError(field, `${getFieldLabel(fieldName)} wajib diisi`);
                return false;
            }

            // Specific validations
            switch (fieldName) {
                case 'price':
                    if (value && (isNaN(value) || parseFloat(value) < 0)) {
                        showError(field, 'Harga harus berupa angka positif');
                        return false;
                    }
                    break;
                case 'stock':
                    if (value && (isNaN(value) || parseInt(value) < 0)) {
                        showError(field, 'Stok harus berupa angka positif');
                        return false;
                    }
                    break;
                case 'name':
                    if (value && value.length < 3) {
                        showError(field, 'Nama produk minimal 3 karakter');
                        return false;
                    }
                    break;
            }

            return true;
        }

        function showError(field, message) {
            field.classList.add('border-red-500', 'error-input');

            const errorDiv = document.createElement('p');
            errorDiv.className = 'text-sm text-red-600 flex items-center mt-1 error-message';
            errorDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i>${message}`;

            field.parentNode.appendChild(errorDiv);
        }

        function clearErrors(field) {
            field.classList.remove('border-red-500', 'error-input');

            const errorMessages = field.parentNode.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());
        }

        function getFieldLabel(fieldName) {
            const labels = {
                'name': 'Nama Produk',
                'category': 'Kategori',
                'price': 'Harga',
                'stock': 'Stok'
            };
            return labels[fieldName] || fieldName;
        }

        function showConfirmDialog(title, message, onConfirm, onCancel = null) {
        const backdrop = document.createElement('div');
        backdrop.className = 'fixed inset-0 bg-opacity-50 backdrop-blur-lg z-50 flex items-center justify-center p-4';
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
                    <i class="fas fa-check mr-2"></i>Ya, Reset
                </button>
            </div>
        </div>
    `;

        backdrop.appendChild(dialog);
        document.body.appendChild(backdrop);

        const style = document.createElement('style');
        style.textContent = `
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
        @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }
        @keyframes scaleOut { from { opacity: 1; transform: scale(1); } to { opacity: 0; transform: scale(0.9); } }
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

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') cancelHandler();
        });
    }


        function resetForm() {
            showConfirmDialog(
                'Reset Formulir',
                'Apakah Anda yakin ingin mereset form ke data asli? Semua perubahan akan hilang.',
                function() {
                    // Reset to original values
                    document.getElementById('name').value = originalValues.name;
                    document.getElementById('category').value = originalValues.category;
                    document.getElementById('price').value = originalValues.price;
                    document.getElementById('stock').value = originalValues.stock;
                    document.getElementById('description').value = originalValues.description;

                    // Reset radio buttons
                    const statusRadios = document.querySelectorAll('input[name="status"]');
                    statusRadios.forEach(radio => {
                        radio.checked = radio.value === originalValues.status;
                    });

                    // Reset image
                    document.getElementById('image').value = '';
                    if (originalValues.image) {
                        document.getElementById('previewImg').src = originalValues.image;
                        document.getElementById('imagePreview').classList.remove('hidden');
                        document.getElementById('uploadArea').classList.add('hidden');
                    } else {
                        document.getElementById('imagePreview').classList.add('hidden');
                        document.getElementById('uploadArea').classList.remove('hidden');
                    }

                    // Clear all errors
                    document.querySelectorAll('.error-message').forEach(msg => msg.remove());
                    document.querySelectorAll('.border-red-500').forEach(field => {
                        field.classList.remove('border-red-500', 'error-input');
                    });
                }
            );
        }

        // Warn user about unsaved changes
        let formChanged = false;
        const formInputs = document.querySelectorAll('input, select, textarea');
        formInputs.forEach(input => {
            input.addEventListener('change', function() {
                formChanged = true;
            });
        });

        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // Reset formChanged flag on successful submit
        document.querySelector('form').addEventListener('submit', function() {
            formChanged = false;
        });
    </script>
@endsection
