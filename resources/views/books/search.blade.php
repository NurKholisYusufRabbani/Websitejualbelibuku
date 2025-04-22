@extends('layouts.app')

@section('content')
    <!-- Search Results -->
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Hasil Pencarian</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($books as $book)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    @if($book->cover_image)
                        <img src="{{ asset('images/' . $book->cover_image) }}" alt="{{ $book->judul }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <span class="text-gray-500 dark:text-gray-400">No Cover</span>
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $book->judul }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $book->penulis }}</p>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ Str::limit($book->deskripsi, 100) }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-lg font-bold text-indigo-600">{{ 'Rp ' . number_format($book->harga, 0, ',', '.') }}</span>
                            <a href="{{ route('books.show', $book->id) }}" class="text-indigo-600 hover:text-indigo-800">Lihat Detail</a>
                        </div>
                    </div>
                </div>
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
