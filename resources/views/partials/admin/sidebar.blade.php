<aside class="bg-gradient-to-b from-gray-900 to-gray-800 text-white shadow-xl h-full">
    <div class="p-6 border-b border-gray-700 flex items-center justify-between">
        <div class="flex items-center space-x-3 header-logo">
            <div class="bg-white p-2 rounded-full flex items-center justify-center icon-container">
                <svg class="w-6 h-6 text-gray-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z"></path>
                </svg>
            </div>
            <h1 class="text-xl font-bold sidebar-logo-text">Admin Portal</h1>
        </div>
        <!-- Close button for mobile only -->
        <button class="sidebar-toggle md:hidden text-white hover:text-gray-300">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="p-4">
        <div class="sidebar-status bg-gray-700 rounded-lg p-4 mb-6">
            <p class="text-xs text-gray-300 mb-1 sidebar-status-text">Status Sistem</p>
            <p class="text-sm font-medium"><span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-2"></span>Online</p>
        </div>
    </div>
    
    <nav class="mt-2 overflow-y-auto" style="max-height: calc(100vh - 240px);">
        <ul class="space-y-1 px-4">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-tachometer-alt w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.product.index') }}" class="nav-link flex items-center px-4 py-3 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-box w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Produk</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link flex items-center px-4 py-3 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-cash-register w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Transaksi</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link flex items-center px-4 py-3 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-coins w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Top-Up</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link flex items-center px-4 py-3 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-wallet w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Riwayat Wallet</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.santri.approvals') }}" class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.santri.approvals') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-user-check w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Persetujuan Santri</span>
                </a>
            </li>
            <li class="pt-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link w-full flex items-center px-4 py-3 rounded-lg text-red-200 hover:bg-red-700 hover:text-white">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        <span class="ml-3 sidebar-text">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>