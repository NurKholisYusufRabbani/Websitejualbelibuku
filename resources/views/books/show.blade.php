@extends('layouts.app')

@section('header')
<header class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-center text-2xl font-bold text-gray-900 dark:text-white">📖 Detail Buku</h1>
    </div>
</header>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <div class="flex flex-col md:flex-row">
            <!-- Gambar Buku -->
            <div class="md:w-1/3 flex justify-center">
                <img src="{{ asset('images/' . $book->cover_image) }}" 
                     alt="{{ $book->judul }}" 
                     class="w-64 h-80 object-cover rounded-lg shadow-md">
            </div>
            
            <!-- Detail Buku -->
            <div class="md:w-2/3 md:ml-6 mt-4 md:mt-0">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $book->judul }}</h1>
                <h2 class="text-lg text-gray-600 dark:text-gray-300 mb-4">Oleh {{ $book->penulis }}</h2>
                <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $book->deskripsi }}</p>
                <p class="text-2xl font-semibold text-blue-600 mb-4">Rp{{ number_format($book->harga, 0, ',', '.') }}</p>
                
                <!-- Input Jumlah -->
                <label for="quantity" class="block text-gray-700 dark:text-gray-300 mb-2">Jumlah:</label>
                <div class="flex items-center justify-between w-full max-w-[140px] border rounded-lg bg-gray-100 dark:bg-gray-700 mb-4">
                    <button id="decrement" 
                            class="px-2 py-1 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-800 dark:text-white rounded-l-lg focus:outline-none">
                        -
                    </button>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" 
                        class="w-10 text-center bg-gray-100 dark:bg-gray-700 dark:text-white border-0 focus:outline-none">
                    <button id="increment" 
                            class="px-2 py-1 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-800 dark:text-white rounded-r-lg focus:outline-none">
                        +
                    </button>
                </div>

                <!-- Tombol Tambah ke Keranjang -->
                <button id="add-to-cart-btn" 
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" 
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.8 14.7a2 2 0 0 0 2 1.6h9.4a2 2 0 0 0 2-1.6L23 6H6"></path>
                    </svg>
                    Tambah ke Keranjang
                </button>

                <!-- Tombol Checkout -->
                <a href="{{ route('cart.index') }}" id="checkout-btn" 
                class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 block text-center hidden">
                    Checkout
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Hilangkan spinner di semua browser */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield; /* Untuk Firefox */
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const quantityInput = document.getElementById('quantity');
        const decrementBtn = document.getElementById('decrement');
        const incrementBtn = document.getElementById('increment');
        const addToCartBtn = document.getElementById('add-to-cart-btn');
        const checkoutBtn = document.getElementById('checkout-btn');

        // Fungsi untuk menambah/mengurangi jumlah
        const updateQuantity = (change) => {
            const value = Math.max(1, parseInt(quantityInput.value) + change);
            quantityInput.value = value;
        };

        decrementBtn.addEventListener('click', () => updateQuantity(-1));
        incrementBtn.addEventListener('click', () => updateQuantity(1));

        // Fungsi untuk menambah ke keranjang
        addToCartBtn.addEventListener('click', () => {
            const bookId = {{ $book->id }};
            const quantity = parseInt(quantityInput.value) || 1;

            fetch(`/cart/add/${bookId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ quantity }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        checkoutBtn.classList.remove('hidden');
                    } else {
                        alert('Gagal menambahkan ke keranjang.');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>
@endsection
