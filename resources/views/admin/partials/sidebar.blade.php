<aside class="w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white min-h-screen p-6 shadow-lg">
    <h2 class="text-2xl font-extrabold tracking-wide text-center mb-6 border-b border-gray-600 pb-2">
        Admin Panel
    </h2>
    <ul class="space-y-3">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 hover:bg-gray-700 rounded-lg transition duration-200">
                <svg class="w-5 h-5 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                </svg>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.books.index') }}" class="flex items-center p-2 hover:bg-gray-700 rounded-lg transition duration-200">
                <svg class="w-5 h-5 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M12 4h9M4 4v16h16" />
                </svg>
                Kelola Buku
            </a>
        </li>
        <li>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center p-2 hover:bg-gray-700 rounded-lg transition duration-200">
                <svg class="w-5 h-5 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6M9 5v6h13V5M3 5h6v14H3z" />
                </svg>
                Kelola Transaksi
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users.index') }}" class="flex items-center p-2 hover:bg-gray-700 rounded-lg transition duration-200">
                <svg class="w-5 h-5 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A7 7 0 0112 15a7 7 0 016.879 2.804M12 7a4 4 0 110 8 4 4 0 010-8z" />
                </svg>
                Kelola Pengguna
            </a>
        </li>
    </ul>
</aside>
