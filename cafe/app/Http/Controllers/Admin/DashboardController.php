<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak');
        }

        // Statistics
        $totalOrders = Order::count();
        $pendingPaymentOrders = Order::where('status_bayar', 'unpaid')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $totalTransactions = Order::where('status_bayar', 'paid')->count();

        // Recent orders with details
        $recentOrders = Order::with(['orderItems.product', 'table'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingPaymentOrders', 
            'processingOrders',
            'totalTransactions',
            'recentOrders'
        ));
    }
}
