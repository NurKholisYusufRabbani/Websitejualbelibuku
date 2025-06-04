<?php

namespace App\Http\Controllers; // Atau App\Http\Controllers\User jika Anda memisahkannya

use Illuminate\Http\Request;
use App\Models\Order; // Pastikan model Order di-import
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang sedang login

class OrderController extends Controller // Atau UserOrderController jika Anda menamakannya demikian
{
    /**
     * Menampilkan daftar pesanan milik pengguna yang sedang login.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Dapatkan user yang sedang terautentikasi
        $user = Auth::user();

        // Jika tidak ada user yang login (seharusnya tidak terjadi jika rute dilindungi middleware 'auth')
        if (!$user) {
            // Anda bisa redirect ke login atau menampilkan error
            return redirect()->route('login')->with('error', 'Anda harus login untuk melihat pesanan.');
        }

        // Mengambil data order milik user yang sedang login dengan pagination
        $orders = Order::with([
            'orderItems.book', // Eager load item buku dalam pesanan (opsional, jika ingin ditampilkan)
            // 'discounts',    // Jika ingin menampilkan diskon yang digunakan (opsional)
            // 'shippingStatus' // Jika pengguna juga perlu melihat status pengiriman detail (opsional)
        ])
        ->where('user_id', $user->id) // Sangat penting: Hanya order milik user yang login
        ->orderByDesc('created_at')   // Urutkan dari yang terbaru
        ->paginate(10); // Ambil 10 order per halaman (Anda bisa sesuaikan jumlahnya)

        // Mengirim data orders ke view yang sesuai untuk pengguna
        // Pastikan path view ini benar, misalnya 'orders.index' atau 'user.orders.index'
        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan milik pengguna.
     * (Contoh method tambahan)
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // Pastikan pesanan ini milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.'); // Atau redirect dengan pesan error
        }

        // Eager load relasi yang dibutuhkan untuk detail
        $order->load(['orderItems.book', 'discounts', 'shippingStatus']);

        // Pastikan path view ini benar
        return view('orders.show', compact('order'));
    }

    // Anda bisa menambahkan method lain yang relevan untuk pengguna di sini
}
