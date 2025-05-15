@extends('layouts.app')

@section('header')
<header class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <h1 class="text-center text-xl font-bold text-gray-900 dark:text-white">❤️ Wishlist Kamu</h1>
    </div>
</header>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
    @if($wishlistBooks->isEmpty())
        <p class="text-center text-gray-700 dark:text-gray-300">Wishlist kamu masih kosong.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($wishlistBooks as $book)
                <a href="{{ route('books.show', $book->id) }}"
                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow hover:shadow-md transition duration-200 rounded-md overflow-hidden transform hover:scale-[1.02] w-full max-w-[200px] mx-auto mt-1.5 h-72 flex flex-col">
                    
                    <div class="h-1/2 w-full">
                        <img src="{{ asset('images/'.$book->cover_image) }}" class="w-full h-full object-cover" alt="{{ $book->judul }}">
                    </div>

                    <div class="h-1/2 p-2 text-left flex flex-col justify-start space-y-1 overflow-hidden">
                        <h5 class="text-sm font-semibold text-gray-900 dark:text-white leading-tight line-clamp-2">{{ $book->judul }}</h5>
                        <p class="text-xs text-gray-700 dark:text-gray-300">Penulis: {{ $book->penulis }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2">{{ $book->deskripsi }}</p>
                        <p class="absolute bottom-2 left-2 text-sm font-bold text-white bg-blue-600 rounded px-2 py-0.5 w-fit">
                            Rp{{ number_format($book->harga, 0, ',', '.') }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
