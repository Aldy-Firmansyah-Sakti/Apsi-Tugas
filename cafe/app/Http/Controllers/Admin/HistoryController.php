<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class HistoryController extends Controller
{
    public function index()
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak');
        }

        // Get statistics
        $completedOrders = Order::where('status', 'completed')->count();
        $totalRevenue = Order::where('status_bayar', 'paid')->sum('total_harga');
        $todayOrders = Order::whereDate('created_at', today())->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        // Get all orders with pagination
        $orders = Order::with(['orderItems.product', 'table'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.history.index', compact(
            'completedOrders',
            'totalRevenue',
            'todayOrders',
            'cancelledOrders',
            'orders'
        ));
    }
}