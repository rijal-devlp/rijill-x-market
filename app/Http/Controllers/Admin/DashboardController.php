<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // Jumlah semua produk
        $totalProducts = Product::count();

        // Jumlah semua pesanan
        $totalOrders = Order::count();

        // Jumlah pesanan berdasarkan status
        $pendingOrders = Order::where('status', 'pending')->count();

        $processedOrders = Order::where('status', 'diproses')->count();

        $shippedOrders = Order::where('status', 'dikirim')->count();

        $completedOrders = Order::where('status', 'selesai')->count();

        // Pendapatan hanya dihitung dari pesanan selesai
        $totalRevenue = Order::where('status', 'selesai')
            ->sum('total_price');

        // Ambil 5 pesanan terbaru
        $latestOrders = Order::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'pendingOrders',
            'processedOrders',
            'shippedOrders',
            'completedOrders',
            'totalRevenue',
            'latestOrders'
        ));
    }
}