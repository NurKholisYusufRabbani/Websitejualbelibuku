@extends('admin.layout')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-gray-800 text-gray-200 shadow-lg rounded-lg">
        <div class="bg-gray-900 text-gray-100 text-lg font-bold px-6 py-4 rounded-t-lg">
            Edit Buku
        </div>
        <div class="p-6">
            @if ($errors->any())
                <div class="bg-red-800 text-red-200 p-4 mb-4 rounded-lg">
                    <strong>Oops! Ada masalah dengan input kamu:</strong>
                    <ul class="mt-2 ml-4 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Judul -->
                <div class="mb-4">
                    <label for="judul" class="block text-sm font-medium text-gray-400">Judul Buku</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $book->judul) }}" 
                        class="mt-1 block w-full px-4 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                        placeholder="Masukkan judul buku" required>
                </div>

                <!-- Penulis -->
                <div class="mb-4">
                    <label for="penulis" class="block text-sm font-medium text-gray-400">Penulis</label>
                    <input type="text" name="penulis" id="penulis" value="{{ old('penulis', $book->penulis) }}" 
                        class="mt-1 block w-full px-4 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                        placeholder="Masukkan nama penulis" required>
                </div>

                <!-- Harga -->
                <div class="mb-4">
                    <label for="harga" class="block text-sm font-medium text-gray-400">Harga</label>
                    <input type="number" name="harga" id="harga" value="{{ old('harga', $book->harga) }}" 
                        class="mt-1 block w-full px-4 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                        placeholder="Masukkan harga buku" required>
                </div>

                <!-- Stok -->
                <div class="mb-4">
                    <label for="stok" class="block text-sm font-medium text-gray-400">Stok</label>
                    <input type="number" name="stok" id="stok" value="{{ old('stok', $book->stok) }}" 
                        class="mt-1 block w-full px-4 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                        placeholder="Masukkan jumlah stok" required>
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategori_id" class="block text-white mb-2">Kategori</label>
                    <select id="kategori_id" name="kategori_id" required 
                            class="w-full p-2 bg-gray-700 text-white rounded">
                        <option value="" disabled {{ old('kategori_id') ? '' : 'selected' }}>Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ $category->id == old('kategori_id') ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-400">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="5" 
                        class="mt-1 block w-full px-4 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                        placeholder="Tuliskan deskripsi buku">{{ old('deskripsi', $book->deskripsi) }}</textarea>
                </div>

                <!-- Cover Image -->
                <div class="mb-6">
                    <label for="cover_image" class="block text-sm font-medium text-gray-400">Cover Buku</label>
                    <input type="file" name="cover_image" id="cover_image" 
                        class="mt-1 block w-1/4 px-3 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-md shadow-sm">
                    @if ($book->cover_image)
                        <div class="mt-4">
                            <label class="block text-sm text-gray-400">Cover Saat Ini:</label>
                            <img src="{{ asset('images/' . $book->cover_image) }}" 
                                alt="Cover Image" class="w-16 h-16 rounded-md border border-gray-600">
                        </div>
                    @endif
                </div>

                <!-- Buttons -->
                <div class="flex justify-between">
                    <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-gray-100 font-semibold rounded-md shadow hover:bg-blue-500 focus:outline-none">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.books.index') }}" 
                        class="px-6 py-2 bg-gray-600 text-gray-200 font-semibold rounded-md shadow hover:bg-gray-500 focus:outline-none">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
