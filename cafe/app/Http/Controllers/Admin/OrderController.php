<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function index()
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak');
        }

        $orders = Order::with('orderItems')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak');
        }

        $order->load('orderItems');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak');
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,ready,delivered,completed,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
            'confirmed_at' => $request->status === 'confirmed' ? now() : $order->confirmed_at,
        ]);

        return response()->json(['success' => true, 'message' => 'Status pesanan berhasil diupdate']);
    }

    public function confirmPayment(Request $request, Order $order)
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak');
        }

        $order->update([
            'status_bayar' => 'paid',
            'paid_at' => now(),
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Pembayaran berhasil dikonfirmasi']);
    }

    public function cancelOrder(Request $request, Order $order)
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak');
        }

        $order->update([
            'status' => 'cancelled',
        ]);

        return response()->json(['success' => true, 'message' => 'Pesanan berhasil dibatalkan']);
    }
}
