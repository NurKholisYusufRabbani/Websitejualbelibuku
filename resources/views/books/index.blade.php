@extends('layouts.app')

@section('header')
<header class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <h1 class="text-center text-xl font-bold text-gray-900 dark:text-white">📚 Daftar Buku</h1>
    </div>
</header>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach($books as $book)
            <a href="{{ route('books.show', $book->id) }}"
            class="relative bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow hover:shadow-md transition duration-200 rounded-md overflow-hidden transform hover:scale-[1.02] w-full max-w-[220px] mx-auto m-2 h-80 flex flex-col">
                
                <!-- Gambar Cover (½ tinggi card) -->
                <div class="h-1/2 w-full">
                    <img src="{{ asset('images/'.$book->cover_image) }}"
                        class="w-full h-full object-cover"
                        alt="{{ $book->judul }}">
                </div>

                <!-- Konten (½ lainnya) -->
                <div class="h-1/2 p-2 pb-8 text-left flex flex-col justify-start space-y-2 overflow-hidden">
                    {{-- Judul --}}
                    <h5 class="text-sm font-semibold text-gray-900 dark:text-white leading-tight line-clamp-2">
                        {{ $book->judul }}
                    </h5>

                    {{-- Penulis --}}
                    <p class="text-xs text-gray-700 dark:text-gray-300">
                        Penulis: {{ $book->penulis }}
                    </p>

                    {{-- Deskripsi --}}
                    <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2">
                        {{ $book->deskripsi }}
                    </p>
                </div>

                {{-- Harga (posisi tetap di bawah) --}}
                <p class="absolute bottom-2 left-2 text-sm font-bold text-white bg-blue-600 rounded px-2 py-0.5 w-fit">
                    Rp{{ number_format($book->harga, 0, ',', '.') }}
                </p>

                <div class="absolute top-2 right-2 z-10">
                    <form action="{{ route('wishlist.toggle', $book->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="focus:outline-none">
                            @if(in_array($book->id, $wishlistBookIds))
                                {{-- Icon hati terisi (sudah di-wishlist) --}}
                                <svg class="w-5 h-5 text-red-600 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.657l-6.828-6.829a4 4 0 010-5.656z"/>
                                </svg>
                            @else
                                {{-- Icon hati kosong --}}
                                <svg class="w-5 h-5 text-gray-400 hover:text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                                </svg>
                            @endif
                        </button>
                    </form>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
