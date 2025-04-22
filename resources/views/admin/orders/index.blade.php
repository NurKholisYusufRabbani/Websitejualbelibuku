@extends('admin.layout')

@section('title', 'Daftar Pesanan')

@section('content')
    <div class="p-6 bg-gray-800 rounded-lg shadow">
        <h1 class="text-2xl font-bold text-white mb-4">📦 Daftar Pesanan</h1>
        <table class="min-w-full text-gray-300">
            <thead>
                <tr class="text-left border-b border-gray-600">
                    <th class="p-3">#</th>
                    <th class="p-3">User</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr class="border-b border-gray-700 hover:bg-gray-700/50">
                        <td class="p-3">{{ $order->id }}</td>
                        <td class="p-3">{{ $order->user->nama }}</td>
                        <td class="p-3 text-green-400 font-semibold">Rp {{ number_format($order->total, 2) }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 text-sm rounded 
                                {{ $order->status == 'completed' ? 'bg-green-600 text-white' : ($order->status == 'pending' ? 'bg-yellow-600 text-white' : 'bg-red-600 text-white') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="p-3">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-400 hover:underline">Detail</a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:underline ml-2" onclick="return confirm('Hapus pesanan ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
