<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - Café X</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-green-800">Café X</h1>
                </div>
                
                <nav class="flex space-x-8">
                    <a href="{{ route('customer.dashboard') }}" class="text-green-600 font-medium border-b-2 border-green-600 pb-1">Dashboard</a>
                    <a href="{{ route('customer.order') }}" class="text-gray-500 hover:text-green-600 transition duration-200">Order</a>
                    <a href="#" class="text-gray-500 hover:text-green-600 transition duration-200">Riwayat</a>
                    <a href="#" class="text-gray-500 hover:text-green-600 transition duration-200">Profil</a>
                </nav>

                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('customer.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p class="text-gray-600">Nikmati pengalaman memesan kopi dan makanan terbaik di Café X</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Quick Actions -->
            <div class="lg:col-span-2">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Menu Populer</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($products->take(4) as $product)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="h-48 bg-gray-200 relative">
                            @if($product->foto)
                                <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-800 mb-1">{{ $product->nama }}</h4>
                            <p class="text-lg font-bold text-green-600 mb-3">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                            <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg font-medium transition duration-200">
                                Pesan Sekarang
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-2 text-center py-8">
                        <p class="text-gray-500">Belum ada menu tersedia</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('customer.order') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 inline-block">
                        Lihat Semua Menu
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Recent Orders -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pesanan Terakhir</h3>
                    @forelse($userOrders as $order)
                    <div class="border-b border-gray-100 pb-3 mb-3 last:border-b-0 last:pb-0 last:mb-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-800">#{{ $order->kode_order }}</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-green-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($order->status == 'completed') bg-green-100 text-green-800
                                    @elseif($order->status == 'processing') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'pending') bg-gray-100 text-gray-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-4">Belum ada pesanan</p>
                    @endforelse
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Anda</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Pesanan</span>
                            <span class="font-semibold text-gray-800">{{ $userOrders->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status Member</span>
                            <span class="font-semibold text-green-600">Regular</span>
                        </div>
                    </div>
                </div>

                <!-- Promo Banner -->
                <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-6 text-white">
                    <h3 class="text-lg font-semibold mb-2">Promo Spesial!</h3>
                    <p class="text-sm mb-4">Dapatkan diskon 20% untuk pembelian minimal Rp 50.000</p>
                    <button class="bg-white text-green-600 px-4 py-2 rounded-lg font-medium text-sm hover:bg-gray-100 transition duration-200">
                        Gunakan Sekarang
                    </button>
                </div>
            </div>
        </div>
    </main>

    <style>
        .bg-cream-100 { background-color: #fdf8f0; }
    </style>
</body>
</html>