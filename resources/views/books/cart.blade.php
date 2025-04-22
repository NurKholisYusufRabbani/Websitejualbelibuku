@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold text-white mb-4">Keranjang Belanja</h2>

    @if($cartItems->count() > 0)
        <div class="bg-gray-800 shadow-lg rounded-lg p-6">
            <table class="w-full text-white">
                <thead>
                    <tr class="border-b border-gray-600">
                        <th class="text-left py-2">Buku</th>
                        <th class="text-center py-2">Jumlah</th>
                        <th class="text-center py-2">Harga</th>
                        <th class="text-center py-2">Total</th>
                        <th class="text-center py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr class="border-b border-gray-600">
                        <td class="py-4 flex items-center">
                            <img src="{{ asset('images/'.$item->book->cover_image) }}" class="w-16 h-20 object-cover rounded-lg mr-4">
                            <div>
                                <p class="font-semibold text-white">{{ $item->book->judul }}</p>
                                <p class="text-sm text-gray-400">{{ $item->book->penulis }}</p>
                            </div>
                        </td>

                        <td class="text-center py-4">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                @csrf
                                <div class="flex items-center justify-between border border-gray-500 rounded-full bg-gray-700 w-24 mx-auto">
                                    <!-- Tombol Minus -->
                                    <button type="button" 
                                        onclick="decrementQuantity({{ $item->id }})" 
                                        class="px-3 py-1 bg-gray-600 hover:bg-gray-500 rounded-l-full text-white text-lg">
                                        -
                                    </button>
                                    <!-- Input Quantity -->
                                    <input type="text" name="jumlah" id="quantity-{{ $item->id }}" 
                                        value="{{ $item->jumlah }}" class="w-10 text-left bg-gray-700 border-0 text-white text-sm" readonly>
                                    <!-- Tombol Plus -->
                                    <button type="button" 
                                        onclick="incrementQuantity({{ $item->id }})" 
                                        class="px-3 py-1 bg-gray-600 hover:bg-gray-500 rounded-r-full text-white text-lg mb-0.1 -ml-2">
                                        +
                                    </button>
                                </div>
                                <!-- Tombol Update -->
                                <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded-lg hover:bg-blue-700 mt-2">
                                    Update
                                </button>
                            </form>
                        </td>

                        <td class="text-center py-4">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="text-center py-4">Rp{{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}</td>
                        <td class="text-center py-4">
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-400 hover:text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 flex justify-between items-center">
                <p class="text-xl font-semibold text-white">
                    Total: <span class="text-blue-400">Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
                </p>
                <a href="{{ route('checkout') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                    Checkout
                </a>
            </div>
        </div>
    @else
        <p class="text-gray-400">Keranjang belanja kosong.</p>
    @endif
</div>

<script>
    function decrementQuantity(id) {
        const quantityInput = document.getElementById(`quantity-${id}`);
        let currentValue = parseInt(quantityInput.value) || 1;
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    }

    function incrementQuantity(id) {
        const quantityInput = document.getElementById(`quantity-${id}`);
        let currentValue = parseInt(quantityInput.value) || 1;
        quantityInput.value = currentValue + 1;
    }
</script>
@endsection
