<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        // Ambil data kategori untuk form pembuatan buku
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'nullable',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori_id' => 'required|exists:categories,id',
        ]);

        // Handle file upload
        $coverImage = null;
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $coverImage = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $coverImage);
        }

        // Simpan data buku
        Book::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'cover_image' => $coverImage,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Book $book)
    {
        // Ambil data kategori untuk form edit
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'nullable',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori_id' => 'required|exists:categories,id',
        ]);

        // Handle file upload
        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama jika ada
            if ($book->cover_image) {
                $oldPath = public_path('images/' . $book->cover_image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file = $request->file('cover_image');
            $coverImage = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $coverImage);
            $book->cover_image = $coverImage;
        }

        // Update data buku
        $book->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'cover_image' => $book->cover_image ?? null, // Tetap gunakan cover lama jika tidak ada upload baru
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        // Hapus gambar jika ada
        if ($book->cover_image) {
            $filePath = public_path('images/' . $book->cover_image);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus buku
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }
}
