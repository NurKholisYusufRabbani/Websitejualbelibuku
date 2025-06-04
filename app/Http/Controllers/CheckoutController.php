<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Discount;
use App\Models\OrderDiscount;

class CheckoutController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        $cartItems = Cart::where('user_id', $user->id)->get();
        $cartTotal = $cartItems->sum(function ($item) {
            return $item->harga * $item->jumlah;
        });

        $discounts = Discount::all();

        return view('checkout.index', compact('cartItems', 'cartTotal', 'discounts'));
    }

    public function process(Request $request)
    {
        $user = auth()->user();

        $cartItems = Cart::where('user_id', $user->id)->get();
        $cartTotal = $cartItems->sum(fn($item) => $item->harga * $item->jumlah);
        $total = $cartTotal;

        $request->validate([
            'alamat_pengiriman' => 'required|string|max:255',
            'discount_id' => 'nullable|exists:discounts,id',
        ]);

        $discount = null;

        if ($request->discount_id) {
            $discount = Discount::find($request->discount_id);
            $discountedTotal = $discount->applyDiscount($cartTotal);
            if ($discountedTotal === false) {
                return back()->withErrors(['discount_id' => 'Minimal pembelian tidak mencukupi untuk diskon ini.']);
            }
            $total = $discountedTotal;
        }

        DB::transaction(function () use ($user, $cartItems, $discount, $total, $request) {
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'pending',
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'tanggal_pemesanan' => now(),
            ]);

            if ($discount) {
                $order->discounts()->attach($discount->id);
            }

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $item->book_id,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->harga,
                ]);
            }

            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Checkout berhasil! Pesanan Anda telah diterima.');
    }
}
