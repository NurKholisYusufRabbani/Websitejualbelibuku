<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wishlistBooks = $user->wishlist()->get(); // ambil buku dari wishlist user

        return view('wishlist.index', compact('wishlistBooks'));
    }

    public function toggle($bookId)
    {
        $user = Auth::user();

        if ($user->wishlist()->where('book_id', $bookId)->exists()) {
            $user->wishlist()->detach($bookId);
        } else {
            $user->wishlist()->attach($bookId);
        }

        return back();
    }
}
