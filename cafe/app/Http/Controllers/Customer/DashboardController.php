<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'customer') {
                abort(403, 'Akses ditolak');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $products = Product::where('is_available', true)->with('category')->get();
        $userOrders = Order::where('nama_pemesan', auth()->user()->name)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('customer.dashboard', compact('products', 'userOrders'));
    }

    public function order()
    {
        $products = Product::where('is_available', true)->with('category')->get();
        return view('customer.order', compact('products'));
    }
}
