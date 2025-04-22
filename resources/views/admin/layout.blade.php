<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white min-h-screen">
            <div class="p-4">
                <h2 class="text-lg font-semibold">Admin Panel</h2>
            </div>
            <nav>
                <ul>
                    <li class="p-2"><a href="{{ route('admin.dashboard') }}" class="hover:text-gray-300">Dashboard</a></li>
                    <li class="p-2"><a href="{{ route('admin.books.index') }}" class="hover:text-gray-300">Kelola Buku</a></li>
                    <li class="p-2"><a href="{{ route('admin.orders.index') }}" class="hover:text-gray-300">Kelola Transaksi</a></li>
                    <li class="p-2"><a href="{{ route('admin.users.index') }}" class="hover:text-gray-300">Kelola Pengguna</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-900">
            @yield('content')
        </main>
    </div>

</body>
</html>
