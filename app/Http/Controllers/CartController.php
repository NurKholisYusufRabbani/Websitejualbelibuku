<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index() {
        $cartItems = Cart::where('user_id', Auth::id())->with('book')->get();
        $cartTotal = $cartItems->sum(fn($item) => $item->jumlah * $item->harga);

        return view('books.cart', compact('cartItems', 'cartTotal'));
    }

    public function view()
    {
    $cartItems = session()->get('cart', []);
    return view('cart.view', compact('cartItems'));
    }

    public function add(Request $request, $bookId) {
        $book = Book::findOrFail($bookId);
    
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $book->stok
        ]);
    
        $cartItem = Cart::where('user_id', Auth::id())->where('book_id', $book->id)->first();
    
        if ($cartItem) {
            $cartItem->jumlah += $request->quantity;
        } else {
            $cartItem = new Cart();
            $cartItem->user_id = Auth::id();
            $cartItem->book_id = $book->id;
            $cartItem->jumlah = $request->quantity;
            $cartItem->harga = $book->harga;
        }
    
        $cartItem->save();
    
        return response()->json([
            'success' => 'Buku berhasil ditambahkan ke keranjang!',
            'cart' => Cart::where('user_id', Auth::id())->get()
        ]);
    }    

    // Fungsi untuk update jumlah item dalam cart
    public function update(Request $request, $itemId)
    {
        // Validasi input jumlah
        $request->validate([
            'jumlah' => 'required|integer|min:1', // Pastikan jumlah adalah angka dan minimal 1
        ]);

        // Mencari item cart berdasarkan ID
        $cartItem = Cart::find($itemId);

        // Cek apakah item ada
        if (!$cartItem) {
            return redirect()->route('cart.index')->with('error', 'Item not found.');
        }

        // Update jumlah item di cart
        $cartItem->jumlah = $request->jumlah;
        $cartItem->save();

        // Redirect ke halaman cart atau halaman lain dengan pesan sukses
        return redirect()->route('cart.index')->with('success', 'Quantity updated successfully!');
    }

    public function remove(Cart $cartItem) {
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item dihapus dari keranjang.');
    }

    public function checkout() {
        return view('checkout');
    }
}
