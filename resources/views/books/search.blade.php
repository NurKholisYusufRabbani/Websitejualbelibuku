@extends('layouts.app')

@section('content')
    <!-- Search Results -->
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Hasil Pencarian</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($books as $book)
                <a href="{{ route('books.show', $book->id) }}" class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden transform hover:scale-105 transition-all duration-300 max-w-xs border border-gray-300 dark:border-gray-700"> <!-- Menambahkan border -->
                    @if($book->cover_image)
                        <img src="{{ asset('images/' . $book->cover_image) }}" alt="{{ $book->judul }}" class="w-full h-56 object-cover"> <!-- Mengubah ukuran gambar menjadi lebih tinggi -->
                    @else
                        <div class="w-full h-56 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <span class="text-gray-500 dark:text-gray-400">No Cover</span>
                        </div>
                    @endif
                    <div class="p-3">
                        <h3 class="text-md font-semibold text-gray-900 dark:text-white">{{ $book->judul }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $book->penulis }}</p>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ Str::limit($book->deskripsi, 80) }}</p>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-md font-bold text-indigo-600">{{ 'Rp ' . number_format($book->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-center text-gray-500 dark:text-gray-400">Tidak ada buku ditemukan.</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $books->links() }}
        </div>
    </div>
@endsection
