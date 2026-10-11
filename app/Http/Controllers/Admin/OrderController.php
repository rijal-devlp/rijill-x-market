<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ORDER LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $orders = Order::latest()->get();

        return view(
            'admin.orders.index',
            compact('orders')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ORDER DETAIL
    |--------------------------------------------------------------------------
    */

    public function show(Order $order)
    {
        $order->load('items');

        return view(
            'admin.orders.show',
            compact('order')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE ORDER STATUS
    |--------------------------------------------------------------------------
    */

    public function updateStatus(
        Request $request,
        Order $order
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,diproses,dikirim,selesai,dibatalkan',
            ],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with(
                'success',
                'Status pesanan berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PAYMENT STATUS
    |--------------------------------------------------------------------------
    */

    public function updatePaymentStatus(
        Request $request,
        Order $order
    ) {
        $validated = $request->validate([
            'payment_status' => [
                'required',
                'in:unpaid,paid',
            ],
        ]);

        $order->update([
            'payment_status' =>
                $validated['payment_status'],
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with(
                'success',
                'Status pembayaran berhasil diperbarui.'
            );
    }
}