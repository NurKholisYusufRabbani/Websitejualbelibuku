<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderItems.book', 'shippingStatus', 'user'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function edit(Order $order)
    {
        $order->load('shippingStatus', 'user');
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $orderStatusEnum = ['pending', 'paid', 'shipped', 'delivered', 'canceled'];
        $shippingStatusEnum = ['processing', 'shipped', 'delivered', 'returned'];

        $request->validate([
            'status' => ['required', 'string', Rule::in($orderStatusEnum)],
            'shipping_status' => ['nullable', 'string', Rule::in($shippingStatusEnum)],
            'tracking_number' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $originalOrderStatus = $order->status;

            $order->status = $request->status;

            if ($request->filled('shipping_status') || $request->filled('tracking_number')) {
                $shippingStatusData = ['tracking_number' => $request->tracking_number];
                if ($request->filled('shipping_status')) {
                    $shippingStatusData['status'] = $request->shipping_status;
                } elseif ($order->shippingStatus && array_key_exists('status', $shippingStatusData) === false) {
                    $shippingStatusData['status'] = $order->shippingStatus->status;
                }


                if(isset($shippingStatusData['status']) || isset($shippingStatusData['tracking_number'])) {
                     $order->shippingStatus()->updateOrCreate(
                        ['order_id' => $order->id],
                        $shippingStatusData
                    );
                }

            } elseif ($order->shippingStatus && !$request->filled('shipping_status') && !$request->filled('tracking_number')) {
                // Opsi: $order->shippingStatus->delete(); atau biarkan
            }

            if ($request->status === 'delivered' && $originalOrderStatus !== 'delivered') {
                $user = $order->user;

                if (!$user) {
                    DB::rollBack();
                    return redirect()->route('admin.orders.edit', $order->id)
                                   ->withInput()
                                   ->with('error', 'User untuk pesanan ini tidak ditemukan. Saldo tidak dipotong.');
                }

                $orderTotal = $order->total;
                $userToUpdate = User::lockForUpdate()->find($user->id);

                if ($userToUpdate->saldo < $orderTotal) {
                    DB::rollBack();
                    return redirect()->route('admin.orders.edit', $order->id)
                                   ->withInput()
                                   ->with('error', 'Saldo pengguna (Rp'.number_format($userToUpdate->saldo,0,',','.').') tidak mencukupi (butuh Rp'.number_format($orderTotal,0,',','.').'). Status pesanan tidak diubah menjadi Delivered.');
                }

                $userToUpdate->saldo -= $orderTotal;
                $userToUpdate->save();
            }

            $order->save();

            DB::commit();

            return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.orders.edit', $order->id)
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan saat memperbarui pesanan: ' . $e->getMessage());
        }
    }

    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }
}