<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class PetugasController extends Controller
{
    // Show dashboard with all orders
    public function dashboard()
    {
        $orders = Order::with(['user', 'items'])
            ->orderBy('id', 'desc')
            ->get();

        $stats = [
            'pending' => Order::where('status', 'pending')->count(),
            'accepted' => Order::where('status', 'accepted')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'total' => Order::count(),
        ];

        return view('petugas.dashboard', compact('orders', 'stats'));
    }

    // Show order detail
    public function showOrder($id)
    {
        $order = Order::with(['user', 'items'])->findOrFail($id);
        return view('petugas.order-detail', compact('order'));
    }

    // Accept order
    public function acceptOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'accepted';
        $order->save();

        return back()->with('success', 'Pesanan berhasil diterima!');
    }

    // Cancel order
    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'cancelled';
        $order->save();

        return back()->with('success', 'Pesanan berhasil dibatalkan!');
    }
}