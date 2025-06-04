<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Gunakan paginate agar lebih scalable
        $orders = Order::with(['orderItems.book', 'shippingStatus', 'user'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string',
            'shipping_status' => 'nullable|string',
            'tracking_number' => 'nullable|string',
        ]);

        $order->status = $request->status;
        $order->save();

        if ($order->shippingStatus) {
            $order->shippingStatus->update([
                'status' => $request->shipping_status,
                'tracking_number' => $request->tracking_number,
            ]);
        } else {
            $order->shippingStatus()->create([
                'status' => $request->shipping_status,
                'tracking_number' => $request->tracking_number,
            ]);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan diperbarui!');
    }
}
