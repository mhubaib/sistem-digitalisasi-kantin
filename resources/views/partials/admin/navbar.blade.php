<header class="bg-white border-b shadow-sm px-4 md:px-8 py-4 flex justify-between items-center">
    <div class="flex items-center">
        <!-- Hamburger menu untuk toggle sidebar -->
        <button class="sidebar-toggle mr-4 text-gray-500 hover:text-gray-700 focus:outline-none" title="Toggle Sidebar">
            <i class="fas fa-bars text-lg"></i>
        </button>
        
        <h2 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
    </div>
    
    <div class="flex items-center space-x-4">
                
        <!-- Notifications -->
        <div class="relative">
            <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="fas fa-bell text-lg"></i>
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">0</span>
            </button>
        </div>
        
        <!-- Admin Profile -->
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center">
                <span class="text-white font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <div class="hidden md:block">
                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">Administrator</p>
            </div>
        </div>
    </div>
</header>