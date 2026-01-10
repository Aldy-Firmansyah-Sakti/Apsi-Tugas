<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pesanan - Café X</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-cream-100 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-green-800 min-h-screen shadow-lg">
            <div class="p-6 border-b border-green-700">
                <h1 class="text-2xl font-bold text-white">Café X</h1>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-green-200 hover:bg-green-700 hover:text-white transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-6 py-3 text-white bg-green-700 border-r-4 border-green-400">
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
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <h1 class="text-2xl font-semibold text-gray-800">Manajemen Pesanan</h1>
                    <div class="text-gray-600 font-medium" id="current-time">{{ date('H.i') }}</div>
                </div>
            </header>

            <main class="p-6">
                <!-- Filter Tabs -->
                <div class="mb-6">
                    <div class="flex space-x-1 bg-gray-100 rounded-lg p-1 w-fit">
                        <button onclick="filterOrders('all')" class="filter-btn active px-4 py-2 text-sm font-medium rounded-md transition-colors">Semua</button>
                        <button onclick="filterOrders('pending')" class="filter-btn px-4 py-2 text-sm font-medium rounded-md transition-colors">Menunggu</button>
                        <button onclick="filterOrders('unpaid')" class="filter-btn px-4 py-2 text-sm font-medium rounded-md transition-colors">Belum Bayar</button>
                        <button onclick="filterOrders('confirmed')" class="filter-btn px-4 py-2 text-sm font-medium rounded-md transition-colors">Dikonfirmasi</button>
                        <button onclick="filterOrders('processing')" class="filter-btn px-4 py-2 text-sm font-medium rounded-md transition-colors">Diproses</button>
                        <button onclick="filterOrders('completed')" class="filter-btn px-4 py-2 text-sm font-medium rounded-md transition-colors">Selesai</button>
                    </div>
                </div>

                <!-- Orders Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="orders-container">
                    @forelse($orders as $order)
                    <div class="order-card bg-white rounded-xl shadow-sm border border-gray-100 p-6" 
                         data-status="{{ $order->status }}" 
                         data-payment="{{ $order->status_bayar }}">
                        
                        <!-- Order Header -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $order->kode_order }}</h3>
                                <p class="text-sm text-gray-500">{{ $order->nama_pemesan }}</p>
                                <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-green-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($order->metode_pembayaran == 'qris') bg-blue-100 text-blue-800 
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($order->metode_pembayaran) }}
                                </span>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Items:</h4>
                            <div class="space-y-1">
                                @foreach($order->orderItems as $item)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">{{ $item->quantity }}x {{ $item->product->nama ?? 'Item' }}</span>
                                    <span class="text-gray-800">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                                <div class="border-t border-gray-200 pt-1 mt-2">
                                    <div class="flex justify-between text-xs text-gray-500">
                                        <span>Subtotal:</span>
                                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                    @if($order->service_fee > 0)
                                    <div class="flex justify-between text-xs text-gray-500">
                                        <span>Biaya Layanan (1%):</span>
                                        <span>Rp {{ number_format($order->service_fee, 0, ',', '.') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Status Badges -->
                        <div class="flex justify-between items-center mb-4">
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
                                @elseif($order->status_bayar == 'unpaid') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                @if($order->status_bayar == 'paid') Sudah Bayar
                                @elseif($order->status_bayar == 'unpaid') Belum Bayar
                                @else {{ ucfirst($order->status_bayar) }} @endif
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-2">
                            @if($order->status_bayar == 'unpaid')
                                <button onclick="confirmPayment({{ $order->id }})" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg font-medium transition duration-200">
                                    Konfirmasi Pembayaran
                                </button>
                            @endif
                            
                            @if($order->status == 'confirmed' || $order->status == 'pending')
                                <button onclick="updateStatus({{ $order->id }}, 'processing')" 
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-medium transition duration-200">
                                    Mulai Proses
                                </button>
                            @endif
                            
                            @if($order->status == 'processing')
                                <button onclick="updateStatus({{ $order->id }}, 'ready')" 
                                        class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-lg font-medium transition duration-200">
                                    Siap Disajikan
                                </button>
                            @endif
                            
                            @if($order->status == 'ready')
                                <button onclick="updateStatus({{ $order->id }}, 'completed')" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg font-medium transition duration-200">
                                    Selesai
                                </button>
                            @endif
                            
                            @if($order->status != 'completed' && $order->status != 'cancelled')
                                <button onclick="cancelOrder({{ $order->id }})" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg font-medium transition duration-200">
                                    Batalkan
                                </button>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pesanan</h3>
                        <p class="text-gray-500">Pesanan customer akan muncul di sini</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
                @endif
            </main>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50">
        <span id="toast-message"></span>
    </div>

    <style>
        .bg-cream-100 { background-color: #fdf8f0; }
        .filter-btn.active {
            background-color: white;
            color: #374151;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .filter-btn:not(.active) {
            color: #6b7280;
        }
        .filter-btn:not(.active):hover {
            color: #374151;
        }
    </style>

    <script>
        function filterOrders(filter) {
            const cards = document.querySelectorAll('.order-card');
            const buttons = document.querySelectorAll('.filter-btn');
            
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
                    case 'confirmed':
                        show = status === 'confirmed';
                        break;
                    case 'processing':
                        show = status === 'processing';
                        break;
                    case 'completed':
                        show = status === 'completed';
                        break;
                }
                
                card.style.display = show ? 'block' : 'none';
            });
        }

        function confirmPayment(orderId) {
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

        function updateStatus(orderId, status) {
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

        function cancelOrder(orderId) {
            if (!confirm('Yakin ingin membatalkan pesanan ini?')) return;
            
            fetch(`/admin/orders/${orderId}/cancel`, {
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

        // Update time every second
        function updateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const timeString = `${hours}.${minutes}`;
            
            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }

        // Update immediately and then every second
        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>
</html>