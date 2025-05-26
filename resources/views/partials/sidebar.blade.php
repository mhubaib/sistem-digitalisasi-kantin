<aside class="w-64 bg-white shadow-md">
    <div class="p-6 border-b">
        <h1 class="text-xl font-bold text-blue-600">Pondok POS</h1>
    </div>
    <nav class="mt-4">
        <ul class="space-y-2">
            <li><a href="{{ route('admin.dashboard') }}" class="block px-6 py-2 text-gray-700 hover:bg-blue-100">Dashboard</a></li>
            <li><a href="{{ route('products.index') }}" class="block px-6 py-2 text-gray-700 hover:bg-blue-100">Produk</a></li>
            <li><a href="{{ route('transactions.index') }}" class="block px-6 py-2 text-gray-700 hover:bg-blue-100">Transaksi</a></li>
            <li><a href="{{ route('topups.index') }}" class="block px-6 py-2 text-gray-700 hover:bg-blue-100">Top-Up</a></li>
            <li><a href="{{ route('wallet.histories') }}" class="block px-6 py-2 text-gray-700 hover:bg-blue-100">Riwayat Wallet</a></li>
            <li><a href="{{ route('admin.santri.approvals') }}" class="block px-6 py-2 text-gray-700 hover:bg-blue-100">Persetujuan Santri</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-6 py-2 text-red-600 hover:bg-red-100">Logout</button>
                </form>
            </li>
        </ul>
    </nav>
</aside>
