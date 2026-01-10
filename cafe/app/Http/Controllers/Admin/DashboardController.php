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

    public function search(Request $request)
    {
        // Check if user is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json(['success' => false, 'message' => 'Query terlalu pendek']);
        }

        // Search orders by order code, customer name, table number, or menu items
        $orders = Order::with(['table', 'orderItems.product'])
            ->where(function($q) use ($query) {
                $q->where('kode_order', 'LIKE', "%{$query}%")
                  ->orWhere('nama_pemesan', 'LIKE', "%{$query}%")
                  ->orWhereHas('table', function($tableQuery) use ($query) {
                      $tableQuery->where('nomor_meja', 'LIKE', "%{$query}%");
                  })
                  ->orWhereHas('orderItems.product', function($productQuery) use ($query) {
                      $productQuery->where('nama', 'LIKE', "%{$query}%");
                  });
            })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $results = $orders->map(function($order) {
            $items = $order->orderItems->map(function($item) {
                return $item->quantity . 'x ' . ($item->product->nama ?? 'Item Deleted');
            })->take(3)->implode(', ');
            
            if ($order->orderItems->count() > 3) {
                $items .= '...';
            }

            return [
                'id' => $order->id,
                'kode_order' => $order->kode_order,
                'nama_pemesan' => $order->nama_pemesan,
                'table_number' => $order->table->nomor_meja ?? null,
                'status' => $order->status,
                'status_bayar' => $order->status_bayar,
                'total_harga' => number_format($order->total_harga, 0, ',', '.'),
                'created_at' => $order->created_at->format('d M Y, H:i'),
                'items' => $items,
            ];
        });

        return response()->json([
            'success' => true,
            'results' => $results
        ]);
    }
}
