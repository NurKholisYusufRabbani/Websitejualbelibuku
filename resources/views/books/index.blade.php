@extends('layouts.app')

@section('header')
<header class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-center text-2xl font-bold text-gray-900 dark:text-white">📚 Daftar Buku</h1>
    </div>
</header>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($books as $book)
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-xl transition-shadow duration-300 rounded-lg overflow-hidden mt-3 transform hover:scale-105">
                <img src="{{ asset('images/'.$book->cover_image) }}" class="w-full h-48 object-cover" alt="{{ $book->judul }}">
                <div class="p-4 text-center">
                    {{-- Badge baru (optional) --}}
                    <span class="inline-block bg-green-500 text-white text-xs px-2 py-1 rounded-full mb-2">Baru</span>

                    {{-- Judul --}}
                    <h5 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                        {{ $book->judul }}
                    </h5>

                    {{-- Penulis --}}
                    <p class="text-sm text-gray-700 dark:text-gray-300">Penulis: {{ $book->penulis }}</p>

                    {{-- Deskripsi singkat (pastikan field deskripsi tersedia) --}}
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">
                        {{ Str::limit($book->deskripsi, 80) }}
                    </p>

                    {{-- Harga --}}
                    <p class="text-lg font-semibold text-white mt-2">
                        Rp{{ number_format($book->harga, 0, ',', '.') }}
                    </p>

                    {{-- Tombol Detail --}}
                    <a href="{{ route('books.show', $book->id) }}" 
                       class="block mt-2 bg-blue-500 text-white text-sm font-semibold py-2 rounded-lg hover:bg-blue-600 text-center">
                       Lihat Detail
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
