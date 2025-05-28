<nav class="bg-white border-b shadow-sm py-4 px-4 md:px-8 flex justify-between items-center">
    <div class="flex items-center">
        <button class="sidebar-toggle mr-4 text-gray-600 hover:text-green-600 focus:outline-none" title="Toggle Sidebar">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <h2 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
    </div>
    
    <div class="flex items-center space-x-4">
        <div class="relative">
            <button class="text-gray-600 hover:text-green-600 focus:outline-none">
                <i class="fas fa-bell text-xl"></i>
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">2</span>
            </button>
        </div>
        
        <div class="relative">
            <div class="flex items-center space-x-3 cursor-pointer">
                <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-semibold">
                    {{ substr(Auth::user()->name ?? 'W', 0, 1) }}
                </div>
                <div class="hidden md:block">
                    <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Wali Santri' }}</p>
                    <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role ?? 'wali') }}</p>
                </div>
            </div>
        </div>
    </div>
</nav>