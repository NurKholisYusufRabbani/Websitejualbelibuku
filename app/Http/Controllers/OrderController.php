<?php

namespace App\Http\Controllers; // Atau App\Http\Controllers\User jika Anda memisahkannya

use App\Models\Order;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang sedang login

class OrderController extends Controller // Atau UserOrderController jika Anda menamakannya demikian
{
    /**
     * Menampilkan daftar pesanan milik pengguna yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();
        $orders = Order::with(['orderItems.book']) // Cukup item buku untuk daftar
                        ->where('user_id', $user->id)
                        ->orderByDesc('created_at')
                        ->paginate(10);

        return view('orders.index', compact('orders')); // Ke view daftar pesanan pengguna
    }

    /**
     * Menampilkan detail satu pesanan milik pengguna, termasuk status pengiriman.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // Pastikan pesanan ini milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk melihat pesanan ini.');
        }

        // Eager load relasi yang dibutuhkan untuk detail, termasuk shippingStatus
        $order->load([
            'orderItems.book', // Item buku dalam pesanan
            'user',            // Informasi pengguna (pemesan)
            'discounts',       // Diskon yang diterapkan pada pesanan ini
            'shippingStatus'   // Status pengiriman pesanan
        ]);

        // Default status jika belum ada entri di shipping_status
        // Biasanya, saat order baru dibuat, status pengiriman belum ada atau 'processing'
        // Anda bisa membuat entri default di ShippingStatus saat order dibuat jika diperlukan,
        // atau menampilkannya sebagai "Belum Diproses" / "Menunggu Konfirmasi" di view.

        // Mengirim data order ke view detail pesanan pengguna
        return view('orders.show', compact('order')); // Ke view detail pesanan pengguna
    }
}
