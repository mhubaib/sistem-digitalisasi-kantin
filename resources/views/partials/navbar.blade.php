<header class="bg-white border-b shadow-sm px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
    <div class="text-sm text-gray-600">
        Login sebagai: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->role }})
    </div>
</header>
