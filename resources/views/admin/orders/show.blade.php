@extends('layouts.admin')

@section('header', 'Detail Pesanan')

@section('content')
<div class="bg-gray-800 p-6 rounded-lg">
    <p><strong>User:</strong> {{ $order->user->nama }}</p>
    <p><strong>Total:</strong> Rp {{ number_format($order->total, 2) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
        @csrf @method('PUT')
        <select name="status" class="p-2 bg-gray-700 text-white rounded">
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
        </select>
        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
    </form>
</div>
@endsection
