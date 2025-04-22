<aside class="w-64 bg-gray-800 text-white min-h-screen p-4">
    <h2 class="text-xl font-bold">Admin Panel</h2>
    <ul class="mt-4 space-y-2">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="block p-2 hover:bg-gray-700 rounded">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('admin.books.index') }}" class="block p-2 hover:bg-gray-700 rounded">Kelola Buku</a>
        </li>
        <li>
            <a href="{{ route('admin.orders.index') }}" class="block p-2 hover:bg-gray-700 rounded">Kelola Transaksi</a>
        </li>
        <li>
            <a href="{{ route('admin.users.index') }}" class="block p-2 hover:bg-gray-700 rounded">Kelola Pengguna</a>
        </li>
    </ul>
</aside>
