@extends('admin.layout')

@section('title', 'Tambah Buku')

@section('content')
    <div class="bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-white">📚 Tambah Buku</h1>

        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul -->
            <div>
                <label for="judul" class="block text-white">Judul Buku</label>
                <input type="text" id="judul" name="judul" required maxlength="255" 
                       class="w-full p-2 bg-gray-700 text-white rounded">
            </div>

            <!-- Penulis -->
            <div>
                <label for="penulis" class="block text-white">Penulis</label>
                <input type="text" id="penulis" name="penulis" required maxlength="255" 
                       class="w-full p-2 bg-gray-700 text-white rounded">
            </div>

            <!-- Harga -->
            <div>
                <label for="harga" class="block text-white">Harga</label>
                <input type="number" id="harga" name="harga" required min="0" 
                       class="w-full p-2 bg-gray-700 text-white rounded">
            </div>

            <!-- Stok -->
            <div>
                <label for="stok" class="block text-white">Stok</label>
                <input type="number" id="stok" name="stok" required min="0" 
                       class="w-full p-2 bg-gray-700 text-white rounded">
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-white">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" required 
                          class="w-full p-2 bg-gray-700 text-white rounded"></textarea>
            </div>

            <!-- Kategori -->
            <div>
                <label for="kategori_id" class="block text-white">Kategori</label>
                <select id="kategori_id" name="kategori_id" required 
                        class="w-full p-2 bg-gray-700 text-white rounded">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Cover Image -->
            <div>
                <label for="cover_image" class="block text-white">Cover Image</label>
                <input type="file" id="cover_image" name="cover_image" required 
                       class="filepond w-full">
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.books.index') }}" 
                   class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <!-- FilePond Plugins -->
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <!-- FilePond Activation -->
    <script>
        // Activate FilePond
        const inputElement = document.querySelector('input[type="file"]');
        FilePond.create(inputElement, {
            allowMultiple: false,
            maxFileSize: '2MB',
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
            labelIdle: 'Drag & Drop your cover image or <span class="filepond--label-action">Browse</span>',
        });

        // Configure FilePond
        FilePond.setOptions({
            server: {
                process: {
                    url: '{{ route("admin.books.upload") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                },
                revert: null,
            }
        });
    </script>
@endsection
