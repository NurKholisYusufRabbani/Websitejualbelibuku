@extends('admin.layout')

@section('title', 'Kelola Buku')

@section('content')
    <div class="bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4 text-white">📚 Kelola Buku</h1>

        <!-- Tombol Tambah Buku -->
        <a href="{{ route('admin.books.create') }}" class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition">
            + Tambah Buku
        </a>

        <!-- Tabel Buku -->
        <div class="overflow-x-auto mt-4">
            <table class="w-full border-collapse border border-gray-700">
                <thead class="bg-gray-700">
                    <tr class="text-left text-gray-300 uppercase text-sm">
                        <th class="p-3 border border-gray-600">ID</th>
                        <th class="p-3 border border-gray-600">Judul</th>
                        <th class="p-3 border border-gray-600">Penulis</th>
                        <th class="p-3 border border-gray-600">Harga</th>
                        <th class="p-3 border border-gray-600">Stok</th>
                        <th class="p-3 border border-gray-600">Deskripsi</th>
                        <th class="p-3 border border-gray-600">Cover</th>
                        <th class="p-3 border border-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                        <tr class="border-t border-gray-600 hover:bg-gray-700">
                            <td class="p-3 border border-gray-600 text-gray-300">{{ $book->id }}</td>
                            <td class="p-3 border border-gray-600 text-gray-300">{{ $book->judul }}</td>
                            <td class="p-3 border border-gray-600 text-gray-300">{{ $book->penulis }}</td>
                            <td class="p-3 border border-gray-600 text-indigo-400 font-medium">Rp{{ number_format($book->harga, 0, ',', '.') }}</td>
                            <td class="p-3 border border-gray-600 text-gray-300">{{ $book->stok }}</td>
                            <td class="p-3 border border-gray-600 text-gray-300">
                                {{ Str::limit($book->deskripsi, 50, '...') }}
                            </td>
                            <td class="p-3 border border-gray-600 text-gray-300">
                                @if($book->cover_image)
                                    <img src="{{ asset('images/' . $book->cover_image) }}" alt="Cover" class="w-16 h-16 object-cover rounded">
                                @else
                                    <span class="text-gray-500 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="p-3 border border-gray-600 text-center">
                                <div class="flex justify-center gap-2">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.books.edit', $book->id) }}" 
                                    class="px-3 py-1 bg-blue-400 text-gray-900 rounded hover:bg-yellow-500 transition">
                                        ✏️ Edit
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Yakin ingin menghapus buku ini?')" 
                                                class="px-3 py-1 bg-red-500 text-gray-900 rounded hover:bg-red-600 transition">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
