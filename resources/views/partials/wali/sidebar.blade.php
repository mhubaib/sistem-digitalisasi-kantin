<aside class="bg-gradient-to-b from-green-800 to-green-900 text-white shadow-xl h-full">
    <div class="p-6 border-b border-green-700 flex items-center justify-between">
        <div class="flex items-center space-x-3 header-logo">
            <div class="bg-white p-2 rounded-full flex items-center justify-center icon-container">
                <svg class="w-6 h-6 text-green-800" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                    </path>
                </svg>
            </div>
            <h1 class="text-xl font-bold sidebar-logo-text">Wali Portal</h1>
        </div>
        <!-- Close button for mobile only -->
        <button class="sidebar-toggle md:hidden text-white hover:text-green-200">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="p-4">
        <div class="sidebar-children bg-green-700 rounded-lg p-4 mb-6">
            <p class="text-xs text-green-200 mb-1 sidebar-children-text">Jumlah Santri yang Diampu</p>
            <p class="text-xl font-bold">{{ Auth::user()->santris()->count() ?? 0 }} Santri</p>
        </div>
    </div>

    <nav class="mt-2 overflow-y-auto" style="max-height: calc(100vh - 240px);">
        <ul class="space-y-1 px-4">
            <li>
                <a href="{{ route('wali.dashboard') }}"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('wali.dashboard') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('wali.transactions') }}"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('wali.transactions') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i class="fas fa-history w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Riwayat Transaksi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('wali.topups') }}"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('wali.topups') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i class="fas fa-wallet w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Riwayat Top-up</span>
                </a>
            </li>
            {{-- <li>
                <a href="#"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('wali.topup.request') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i class="fas fa-plus-circle w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Permintaan Top-up</span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('wali.statistics') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i class="fas fa-chart-bar w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Statistik Penggunaan</span>
                </a>
            </li> --}}
            <li>
                <a href="{{ route('wali.notifications.history') }}"
                    class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('wali.notifications.history') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i class="fas fa-bell w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Notifikasi</span>
                </a>
            </li>
            <li class="pt-36">
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
