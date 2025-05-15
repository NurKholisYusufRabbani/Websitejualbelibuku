<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        $wishlistBookIds = auth()->check()
            ? auth()->user()->wishlist()->pluck('books.id')->toArray()
            : [];

        return view('books.index', compact('books', 'wishlistBookIds'));
    }

    public function show($id) {
        $book = Book::findOrFail($id);
        return view('books.show', compact('book'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query', '');

        $books = Book::when($query, function ($q) use ($query) {
                    $q->where('judul', 'like', "%{$query}%")
                    ->orWhere('penulis', 'like', "%{$query}%");
                })
                ->paginate(9)
                ->appends(['query' => $query]);

        return view('books.search', compact('books', 'query'));
    }
}
