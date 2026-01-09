<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Café X</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-cream-100 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-green-800 min-h-screen shadow-lg">
            <!-- Logo -->
            <div class="p-6 border-b border-green-700">
                <h1 class="text-2xl font-bold text-white">Café X</h1>
            </div>

            <!-- Navigation -->
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-white bg-green-700 border-r-4 border-green-400">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-6 py-3 text-green-200 hover:bg-green-700 hover:text-white transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Pesanan
                </a>
                
                <a href="{{ route('admin.menu.index') }}" class="flex items-center px-6 py-3 text-green-200 hover:bg-green-700 hover:text-white transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Menu
                </a>
                
                <a href="{{ route('admin.history.index') }}" class="flex items-center px-6 py-3 text-green-200 hover:bg-green-700 hover:text-white transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Riwayat
                </a>
                
                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-6 py-3 text-green-200 hover:bg-green-700 hover:text-white transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Pengaturan
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-8">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-6 py-3 text-green-200 hover:bg-red-600 hover:text-white transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout Admin
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text" placeholder="Search" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        
                        <!-- Time -->
                        <div class="text-gray-600 font-medium">10.42</div>
                        
                        <!-- Profile -->
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="p-6">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Pesanan -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm mb-1">Total pesanan</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Pesanan Menunggu Pembayaran -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm mb-1">Pesanan menunggu pembayaran</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $pendingPaymentOrders }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Pesanan Diproses -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm mb-1">Pesanan diproses</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $processingOrders }}</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Transaksi -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm mb-1">Total transaksi</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $totalTransactions }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Pesanan Terbaru</h2>
                            <a href="{{ route('admin.orders.index') }}" class="text-green-600 hover:text-green-700 font-medium">Lihat Semua</a>
                        </div>
                        
                        <!-- Filter Tabs -->
                        <div class="flex space-x-1 bg-gray-100 rounded-lg p-1 w-fit">
                            <button onclick="filterDashboardOrders('all')" class="dashboard-filter-btn active px-4 py-2 text-sm font-medium rounded-md">Semua</button>
                            <button onclick="filterDashboardOrders('pending')" class="dashboard-filter-btn px-4 py-2 text-sm font-medium rounded-md">Menunggu</button>
                            <button onclick="filterDashboardOrders('unpaid')" class="dashboard-filter-btn px-4 py-2 text-sm font-medium rounded-md">Belum Bayar</button>
                            <button onclick="filterDashboardOrders('processing')" class="dashboard-filter-btn px-4 py-2 text-sm font-medium rounded-md">Diproses</button>
                        </div>
                    </div>

                    <!-- Orders List -->
                    <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                        @forelse($recentOrders as $order)
                        <div class="dashboard-order-card p-4" data-status="{{ $order->status }}" data-payment="{{ $order->status_bayar }}">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="font-semibold text-gray-800">{{ $order->kode_order }}</h3>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            @if($order->status == 'completed') bg-green-100 text-green-800
                                            @elseif($order->status == 'processing') bg-yellow-100 text-yellow-800
                                            @elseif($order->status == 'confirmed') bg-blue-100 text-blue-800
                                            @elseif($order->status == 'pending') bg-gray-100 text-gray-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            @if($order->status_bayar == 'paid') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            @if($order->status_bayar == 'paid') Sudah Bayar @else Belum Bayar @endif
                                        </span>
                                    </div>
                                    
                                    <div class="text-sm text-gray-600 mb-2">
                                        <p><strong>Customer:</strong> {{ $order->nama_pemesan }}</p>
                                        <p><strong>Meja:</strong> {{ $order->table->nomor_meja ?? 'N/A' }}</p>
                                        <p><strong>Waktu:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                                        <p><strong>Pembayaran:</strong> {{ ucfirst($order->metode_pembayaran) }}</p>
                                    </div>

                                    <!-- Order Items -->
                                    <div class="bg-gray-50 rounded-lg p-3 mb-3">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Items Pesanan:</h4>
                                        <div class="space-y-1">
                                            @foreach($order->orderItems as $item)
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">{{ $item->quantity }}x {{ $item->product->nama ?? 'Item Deleted' }}</span>
                                                <span class="text-gray-800">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                            </div>
                                            @endforeach
                                            <div class="border-t border-gray-200 pt-1 mt-2">
                                                <div class="flex justify-between text-sm text-gray-600">
                                                    <span>Subtotal:</span>
                                                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                                                </div>
                                                @if($order->service_fee > 0)
                                                <div class="flex justify-between text-sm text-gray-600">
                                                    <span>Biaya Layanan (1%):</span>
                                                    <span>Rp {{ number_format($order->service_fee, 0, ',', '.') }}</span>
                                                </div>
                                                @endif
                                                <div class="flex justify-between font-semibold">
                                                    <span>Total:</span>
                                                    <span class="text-green-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="flex space-x-2">
                                @if($order->status_bayar == 'unpaid')
                                    <button onclick="quickConfirmPayment({{ $order->id }})" 
                                            class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition duration-200">
                                        Konfirmasi Bayar
                                    </button>
                                @endif
                                
                                @if($order->status == 'confirmed' || $order->status == 'pending')
                                    <button onclick="quickUpdateStatus({{ $order->id }}, 'processing')" 
                                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition duration-200">
                                        Mulai Proses
                                    </button>
                                @endif
                                
                                @if($order->status == 'processing')
                                    <button onclick="quickUpdateStatus({{ $order->id }}, 'ready')" 
                                            class="flex-1 bg-orange-600 hover:bg-orange-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition duration-200">
                                        Siap Disajikan
                                    </button>
                                @endif
                                
                                @if($order->status == 'ready')
                                    <button onclick="quickUpdateStatus({{ $order->id }}, 'completed')" 
                                            class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition duration-200">
                                        Selesai
                                    </button>
                                @endif
                                
                                <a href="{{ route('admin.orders.index') }}" 
                                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-3 rounded-lg text-sm font-medium transition duration-200">
                                    Detail
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pesanan</h3>
                            <p class="text-gray-500">Pesanan customer akan muncul di sini</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </main>
        </div>
    </div>

    <style>
        .bg-cream-100 { background-color: #fdf8f0; }
        .dashboard-filter-btn.active {
            background-color: white;
            color: #374151;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .dashboard-filter-btn:not(.active) {
            color: #6b7280;
        }
        .dashboard-filter-btn:not(.active):hover {
            color: #374151;
        }
    </style>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50">
        <span id="toast-message"></span>
    </div>

    <script>
        function filterDashboardOrders(filter) {
            const cards = document.querySelectorAll('.dashboard-order-card');
            const buttons = document.querySelectorAll('.dashboard-filter-btn');
            
            // Update active button
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Filter cards
            cards.forEach(card => {
                const status = card.dataset.status;
                const payment = card.dataset.payment;
                
                let show = false;
                
                switch(filter) {
                    case 'all':
                        show = true;
                        break;
                    case 'pending':
                        show = status === 'pending';
                        break;
                    case 'unpaid':
                        show = payment === 'unpaid';
                        break;
                    case 'processing':
                        show = status === 'processing';
                        break;
                }
                
                card.style.display = show ? 'block' : 'none';
            });
        }

        function quickConfirmPayment(orderId) {
            if (!confirm('Konfirmasi pembayaran untuk pesanan ini?')) return;
            
            fetch(`/admin/orders/${orderId}/confirm-payment`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan', 'error');
            });
        }

        function quickUpdateStatus(orderId, status) {
            fetch(`/admin/orders/${orderId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan', 'error');
            });
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            
            toastMessage.textContent = message;
            toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg transform transition-transform duration-300 z-50 ${type === 'error' ? 'bg-red-500' : 'bg-green-500'} text-white`;
            
            // Show toast
            toast.style.transform = 'translateX(0)';
            
            // Hide toast after 3 seconds
            setTimeout(() => {
                toast.style.transform = 'translateX(100%)';
            }, 3000);
        }

        // Auto refresh every 30 seconds
        setInterval(() => {
            location.reload();
        }, 30000);
    </script>
</body>
</html>