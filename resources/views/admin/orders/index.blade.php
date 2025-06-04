@extends('admin.layout')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="p-6 bg-gray-900 rounded-lg shadow text-gray-200">
    <h1 class="text-2xl font-bold mb-6">📦 Daftar Pesanan</h1>

    <div class="overflow-x-auto rounded-lg">
        <table class="min-w-full bg-gray-800 rounded-lg overflow-hidden">
            <thead>
                <tr class="text-left text-gray-400 uppercase text-sm bg-gray-700 border-b border-gray-600">
                    <th class="p-3">#</th>
                    <th class="p-3">User</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-b border-gray-700 hover:bg-gray-700/40 transition">
                        <td class="p-3">{{ $order->id }}</td>
                        <td class="p-3">{{ $order->user->nama ?? 'N/A' }}</td>
                        <td class="p-3 text-green-400 font-semibold">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 text-xs font-medium rounded 
                                {{ 
                                    $order->status === 'completed' ? 'bg-green-600 text-white' : 
                                    ($order->status === 'pending' ? 'bg-yellow-600 text-white' : 
                                    ($order->status === 'cancelled' ? 'bg-red-600 text-white' : 'bg-gray-600 text-white')) 
                                }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="p-3 flex space-x-2">
                            <a href="{{ route('admin.orders.edit', $order) }}" class="text-blue-400 hover:underline">Edit</a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-400">Tidak ada pesanan ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links('pagination::tailwind') }}
    </div>
</div>
@endsection
