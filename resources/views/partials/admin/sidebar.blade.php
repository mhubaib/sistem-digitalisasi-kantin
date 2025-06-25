<aside class="bg-gradient-to-b from-gray-900 to-gray-800 text-white shadow-xl h-full">
    <div class="p-6 border-b border-gray-700 flex items-center justify-between">
        <div class="flex items-center space-x-3 header-logo">
            <div class="bg-white p-2 rounded-full flex items-center justify-center icon-container">
                <svg class="w-6 h-6 text-gray-800" fill="currentColor" viewBox="0 0 512 512"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M399 384.2C376.9 345.8 335.4 320 288 320l-64 0c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 16a72 72 0 1 0 0-144 72 72 0 1 0 0 144z" />
                </svg>
            </div>
            <h1 class="text-xl font-bold sidebar-logo-text">Admin Panel</h1>
        </div>
        <!-- Close button for mobile only -->
        <button class="sidebar-toggle md:hidden text-white hover:text-gray-300">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="p-4">
        <div class="sidebar-status bg-gray-700 rounded-lg p-4 mb-6">
            <p class="text-xs text-gray-300 mb-1 sidebar-status-text">Status Sistem</p>
            <p class="text-sm font-medium"><span
                    class="inline-block w-2 h-2 bg-green-500 rounded-full mr-2"></span>Online</p>
        </div>
    </div>

    <nav class="mt-2 overflow-y-auto" style="max-height: calc(100vh - 240px);">
        <ul class="space-y-1 px-4">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-tachometer-alt w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.product.index') }}"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.product.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-box w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Produk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.admin.transaction.cart') }}"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.admin.transaction.cart') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-cash-register w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Transaksi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.topup.index') }}"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.topup.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-coins w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Top-Up</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.expenses.index') }}"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.expenses.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-money-bill-wave w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Pengeluaran</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.wallet_histories.index') }}"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.wallet_histories.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-wallet w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Riwayat Wallet</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transaction.index') }}"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('transaction.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-history w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Riwayat Transaksi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.santri.approvals') }}"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.santri.approvals') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-user-check w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Persetujuan Santri</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.notifications.history') }}"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.notifications.history') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-bell w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Notifikasi</span>
                </a>
            </li>
            <li class="pt-16">
                @if (session('status'))
                    <div class="bg-red-500 text-white p-2 rounded mb-2">{{ session('status') }}</div>
                @endif
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="button"
                        onclick="showConfirmDialog('Konfirmasi Logout', 'Apakah anda yakin ingin logout?', function() { document.getElementById('logout-form').submit(); })"
                        class="nav-link w-full flex items-center px-4 py-3 rounded-lg text-red-200 hover:bg-red-700 hover:text-white">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        <span class="ml-3 sidebar-text">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>
<script>
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
                    <i class="fas fa-check mr-2"></i>Ya, Logout
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
</script>
