<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function welcome()
    {
        return view('customer.welcome');
    }

    public function index()
    {
        // Redirect to welcome if accessed directly
        return redirect()->route('home');
    }

    public function startOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'table_number' => 'required|integer|min:1|max:10',
        ]);

        // Check if table exists, if not create it
        $table = Table::firstOrCreate(
            ['nomor_meja' => $request->table_number],
            [
                'kapasitas' => 4,
                'status' => 'occupied',
                'qr_code' => 'QR-TABLE-' . str_pad($request->table_number, 3, '0', STR_PAD_LEFT),
            ]
        );

        // Create session ID for this order
        $sessionId = Str::random(32);
        
        // Store customer info in session
        session([
            'order_session_' . $sessionId => [
                'customer_name' => $request->customer_name,
                'table_id' => $table->id,
                'table_number' => $request->table_number,
                'cart' => [],
                'created_at' => now(),
            ]
        ]);

        return redirect()->route('customer.menu', ['session_id' => $sessionId]);
    }

    public function menu($sessionId)
    {
        $orderSession = session('order_session_' . $sessionId);
        
        if (!$orderSession) {
            return redirect()->route('home')->with('error', 'Session tidak valid. Silakan mulai pesanan baru.');
        }

        $products = Product::where('is_available', true)->with('category')->get();
        $categories = $products->groupBy('category.nama');

        return view('customer.menu', compact('products', 'categories', 'sessionId', 'orderSession'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $sessionKey = 'order_session_' . $request->session_id;
        $orderSession = session($sessionKey);

        if (!$orderSession) {
            return response()->json(['error' => 'Session tidak valid'], 400);
        }

        $product = Product::find($request->product_id);
        $cartKey = $product->id;

        // Add or update cart item
        if (isset($orderSession['cart'][$cartKey])) {
            $orderSession['cart'][$cartKey]['quantity'] += $request->quantity;
        } else {
            $orderSession['cart'][$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->nama,
                'price' => $product->harga,
                'foto' => $product->image_url, // Add product image URL
                'quantity' => $request->quantity,
            ];
        }

        session([$sessionKey => $orderSession]);

        return response()->json([
            'success' => true, 
            'message' => 'Item ditambahkan ke keranjang'
        ]);
    }

    public function cart($sessionId)
    {
        $orderSession = session('order_session_' . $sessionId);
        
        if (!$orderSession) {
            return redirect()->route('home')->with('error', 'Session tidak valid. Silakan mulai pesanan baru.');
        }

        $cart = $orderSession['cart'] ?? [];
        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        
        // Calculate 1% service fee
        $serviceFee = $subtotal * 0.01;
        $total = $subtotal + $serviceFee;

        return view('customer.cart', compact('cart', 'subtotal', 'serviceFee', 'total', 'sessionId', 'orderSession'));
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:50',
        ]);

        $sessionKey = 'order_session_' . $request->session_id;
        $orderSession = session($sessionKey);

        if (!$orderSession) {
            return response()->json(['error' => 'Session tidak valid'], 400);
        }

        $cartKey = $request->product_id;

        // Update cart item quantity
        if (isset($orderSession['cart'][$cartKey])) {
            $orderSession['cart'][$cartKey]['quantity'] = $request->quantity;
            session([$sessionKey => $orderSession]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Jumlah item berhasil diupdate',
                'new_quantity' => $request->quantity
            ]);
        }

        return response()->json(['error' => 'Item tidak ditemukan di keranjang'], 404);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'product_id' => 'required|exists:products,id',
        ]);

        $sessionKey = 'order_session_' . $request->session_id;
        $orderSession = session($sessionKey);

        if (!$orderSession) {
            return response()->json(['error' => 'Session tidak valid'], 400);
        }

        $cartKey = $request->product_id;

        // Remove item from cart
        if (isset($orderSession['cart'][$cartKey])) {
            unset($orderSession['cart'][$cartKey]);
            session([$sessionKey => $orderSession]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Item berhasil dihapus dari keranjang'
            ]);
        }

        return response()->json(['error' => 'Item tidak ditemukan di keranjang'], 404);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'payment_method' => 'required|in:cash,qris',
        ]);

        $sessionKey = 'order_session_' . $request->session_id;
        $orderSession = session($sessionKey);

        if (!$orderSession || empty($orderSession['cart'])) {
            return redirect()->route('home')->with('error', 'Keranjang kosong atau session tidak valid.');
        }

        // Calculate totals
        $subtotal = collect($orderSession['cart'])->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        
        // Calculate 1% service fee
        $serviceFee = $subtotal * 0.01;
        $totalHarga = $subtotal + $serviceFee;

        // Create order
        $order = Order::create([
            'kode_order' => 'ORD-' . strtoupper(Str::random(6)),
            'table_id' => $orderSession['table_id'],
            'nama_pemesan' => $orderSession['customer_name'],
            'status' => 'pending',
            'subtotal' => $subtotal,
            'service_fee' => $serviceFee,
            'total_harga' => $totalHarga,
            'metode_pembayaran' => $request->payment_method,
            'status_bayar' => 'unpaid',
        ]);

        // Create order items
        foreach ($orderSession['cart'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Clear session
        session()->forget($sessionKey);

        return view('customer.order-success', compact('order'));
    }

    public function orderStatus($id)
    {
        $order = Order::with(['orderItems.product', 'table'])->findOrFail($id);
        return view('customer.order-status', compact('order'));
    }

    public function getOrderStatus($id)
    {
        try {
            $order = Order::with(['orderItems.product', 'table'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'order' => [
                    'id' => $order->id,
                    'kode_order' => $order->kode_order,
                    'status' => $order->status,
                    'status_bayar' => $order->status_bayar,
                    'nama_pemesan' => $order->nama_pemesan,
                    'total_harga' => $order->total_harga,
                    'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $order->updated_at->format('Y-m-d H:i:s'),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }
    }
}
