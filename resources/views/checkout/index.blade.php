@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Checkout</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow space-y-6">
        @csrf

        <!-- Alamat Pengiriman -->
        <div>
            <label for="alamat" class="block text-gray-700 dark:text-white font-medium mb-2">Alamat Pengiriman</label>
            <textarea name="alamat_pengiriman" id="alamat" rows="4" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('alamat_pengiriman') }}</textarea>
        </div>

        {{-- Dropdown diskon --}}
        <div class="mb-4">
            <label class="text-white block mb-2">Pilih Diskon (Opsional)</label>
            <select name="discount_id" id="discount_id" class="w-full p-2 rounded">
                <option value="" data-persentase="0" data-minimal="0">-- Tidak pakai diskon --</option>
                @foreach ($discounts as $discount)
                    <option 
                        value="{{ $discount->id }}" 
                        data-persentase="{{ $discount->persentase }}" 
                        data-minimal="{{ $discount->minimal_pembelian }}"
                    >
                        {{ $discount->kode }} - {{ $discount->persentase }}% (Min: Rp{{ number_format($discount->minimal_pembelian, 0, ',', '.') }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Ringkasan Pesanan -->
        <div>
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Ringkasan Pesanan</h4>
            <ul class="space-y-2 text-gray-700 dark:text-gray-200">
                @foreach($cartItems as $item)
                    <li class="flex justify-between border-b pb-2">
                        <span>{{ $item->book->judul }} (x{{ $item->jumlah }})</span>
                        <span>Rp{{ number_format($item->harga, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
            <p class="mt-4 text-xl font-bold text-gray-800 dark:text-white">
                Total: 
                <span id="totalBeforeDiscount">Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
                <span id="totalAfterDiscount" class="ml-2"></span>
            </p>
        </div>

        <!-- Tombol Proses -->
        <div class="text-right">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Proses Checkout
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectDiscount = document.getElementById('discount_id');
        const totalBeforeElem = document.getElementById('totalBeforeDiscount');
        const totalAfterElem = document.getElementById('totalAfterDiscount');

        let originalTotal = {{ $cartTotal }};

        selectDiscount.addEventListener('change', function() {
            const selectedOption = selectDiscount.options[selectDiscount.selectedIndex];
            const persen = parseFloat(selectedOption.getAttribute('data-persentase')) || 0;
            const minimal = parseInt(selectedOption.getAttribute('data-minimal')) || 0;

            if (persen > 0 && originalTotal >= minimal) {
                const discounted = originalTotal - (originalTotal * persen / 100);
                // Coret total sebelum diskon
                totalBeforeElem.style.textDecoration = 'line-through';
                // Tampilkan total setelah diskon normal (tdk dicoret)
                totalAfterElem.textContent = 'Rp' + discounted.toLocaleString('id-ID');
                totalAfterElem.style.color = '#e53e3e'; // merah
                totalAfterElem.style.fontWeight = 'bold';
            } else {
                // Kembalikan ke normal jika diskon tidak valid atau kosong
                totalBeforeElem.style.textDecoration = 'none';
                totalAfterElem.textContent = '';
            }
        });
    });
</script>
@endsection
