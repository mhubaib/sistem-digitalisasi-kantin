<aside class="bg-gradient-to-b from-blue-800 to-blue-900 text-white shadow-xl h-full">
    <div class="p-6 border-b border-blue-700 flex items-center justify-between">
        <div class="flex items-center space-x-3 header-logo">
            <div class="bg-white p-2 rounded-full flex items-center justify-center icon-container">
                <svg class="w-6 h-6 text-blue-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-2.727 1.666 1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zm5.99 7.176A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                </svg>
            </div>
            <h1 class="text-xl font-bold sidebar-logo-text">Santri Portal</h1>
        </div>
        <!-- Close button for mobile only -->
        <button class="sidebar-toggle md:hidden text-white hover:text-blue-200">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="p-4">
        <div class="sidebar-balance bg-blue-700 rounded-lg p-4 mb-6 text-center">
            <p class="text-xs text-blue-200 mb-1 sidebar-balance-text">Saldo Anda</p>
            <p class="text-xl font-bold">Rp {{ number_format(Auth::user()->santri->saldo ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <nav class="mt-2 overflow-y-auto" style="max-height: calc(100vh - 240px);">
        <ul class="space-y-1 px-4">
            <li>
                <a href="{{ route('santri.dashboard') }}" class="nav-link flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('santri.dashboard') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link flex items-center px-4 py-3 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-shopping-cart w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Products</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link flex items-center px-4 py-3 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-history w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Riwayat Transaksi</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link flex items-center px-4 py-3 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-wallet w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Riwayat Saldo</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link flex items-center px-4 py-3 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-user w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Profil</span>
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