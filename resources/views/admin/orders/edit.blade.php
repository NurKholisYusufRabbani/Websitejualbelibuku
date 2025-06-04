@extends('admin.layout')

@section('title', 'Edit Pesanan - #' . $order->id)

@section('content')
<div class="p-6 bg-gray-900 rounded-lg shadow text-gray-200">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">📝 Edit Pesanan #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white transition">
            &larr; Kembali ke Daftar Pesanan
        </a>
    </div>

    {{-- Tampilkan pesan error umum atau error saldo dari session --}}
    @if (session('error'))
        <div class="mb-4 p-3 text-sm text-red-200 bg-red-700/50 rounded-lg" role="alert">
            {{ session('error') }}
        </div>
    @endif
    {{-- Pesan sukses biasanya ditampilkan di halaman index setelah redirect,
         tapi bisa juga diletakkan di sini jika ada alur yang kembali ke edit dengan pesan sukses --}}
    @if (session('success'))
        <div class="mb-4 p-3 text-sm text-green-200 bg-green-700/50 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="user_info" class="block text-sm font-medium text-gray-400 mb-1">Pemesan</label>
            <input type="text" id="user_info" value="{{ $order->user->nama ?? 'N/A' }} ({{ $order->user->email ?? 'N/A' }})"
                   class="w-full p-3 bg-gray-800 border border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-300" readonly>
        </div>

        <div>
            <label for="total_amount" class="block text-sm font-medium text-gray-400 mb-1">Total Pesanan</label>
            <input type="text" id="total_amount" value="Rp{{ number_format($order->total, 0, ',', '.') }}"
                   class="w-full p-3 bg-gray-800 border border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-300" readonly>
        </div>

        {{-- Status Pesanan Utama --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-400 mb-1">Status Pesanan Utama</label>
            <select id="status" name="status" class="w-full p-3 bg-gray-800 border border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-200 @error('status') border-red-500 @enderror">
                {{-- ENUM: ('pending','paid','shipped','delivered','canceled') --}}
                <option value="pending" {{ (old('status', $order->status) == 'pending') ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ (old('status', $order->status) == 'paid') ? 'selected' : '' }}>Paid</option>
                <option value="shipped" {{ (old('status', $order->status) == 'shipped') ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ (old('status', $order->status) == 'delivered') ? 'selected' : '' }}>Delivered</option>
                <option value="canceled" {{ (old('status', $order->status) == 'canceled') ? 'selected' : '' }}>Canceled</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Detail Pengiriman --}}
        <div class="border-t border-gray-700 pt-6">
            <h2 class="text-lg font-semibold mb-3 text-gray-300">Detail Pengiriman</h2>
            <div>
                <label for="shipping_status" class="block text-sm font-medium text-gray-400 mb-1">Status Pengiriman</label>
                <select name="shipping_status" id="shipping_status" class="w-full p-3 bg-gray-800 border border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-200 @error('shipping_status') border-red-500 @enderror">
                    <option value="">-- Pilih Status Pengiriman (Opsional) --</option>
                    {{-- ENUM: ('processing','shipped','delivered','returned') --}}
                    <option value="processing" {{ (old('shipping_status', $order->shippingStatus->status ?? '') == 'processing') ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ (old('shipping_status', $order->shippingStatus->status ?? '') == 'shipped') ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ (old('shipping_status', $order->shippingStatus->status ?? '') == 'delivered') ? 'selected' : '' }}>Delivered</option>
                    <option value="returned" {{ (old('shipping_status', $order->shippingStatus->status ?? '') == 'returned') ? 'selected' : '' }}>Returned</option>
                </select>
                @error('shipping_status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <label for="tracking_number" class="block text-sm font-medium text-gray-400 mb-1">Nomor Resi</label>
                <input type="text" name="tracking_number" id="tracking_number"
                       value="{{ old('tracking_number', $order->shippingStatus->tracking_number ?? '') }}"
                       placeholder="Contoh: JNE1234567890 (Opsional)"
                       class="w-full p-3 bg-gray-800 border border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('tracking_number') border-red-500 @enderror">
                @error('tracking_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection