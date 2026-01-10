<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan - Café X</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-cream-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-green-800">Café X</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Real-time Clock -->
                    <div class="text-gray-600 font-medium" id="current-time">{{ date('H.i') }}</div>
                    <div class="text-sm text-gray-600">
                        Status Pesanan
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <!-- Order Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Pesanan Anda</h2>
                <p class="text-gray-600">Kode Pesanan: <span class="font-semibold text-green-600" id="order-code">{{ $order->kode_order }}</span></p>
            </div>

            <!-- Order Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Detail Pesanan</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama Pemesan:</span>
                            <span class="font-medium">{{ $order->nama_pemesan }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nomor Meja:</span>
                            <span class="font-medium">{{ $order->table->nomor_meja ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Metode Pembayaran:</span>
                            <span class="font-medium">{{ ucfirst($order->metode_pembayaran) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Estimasi Selesai:</span>
                            <span class="font-medium" id="estimated-completion">
                                Menghitung...<span class="realtime-indicator"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Ringkasan Pembayaran</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Biaya Layanan (1%):</span>
                            <span class="font-medium">Rp {{ number_format($order->service_fee, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-2">
                            <div class="flex justify-between font-semibold">
                                <span>Total:</span>
                                <span class="text-green-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Progress -->
            <div class="mb-8">
                <h3 class="font-semibold text-gray-800 mb-6">Status Pesanan</h3>
                <div class="flex items-center justify-between relative">
                    <!-- Progress Line -->
                    <div class="absolute top-4 left-0 w-full h-0.5 bg-gray-200">
                        <div class="h-full bg-green-500 transition-all duration-500" id="progress-line" style="width: 0%"></div>
                    </div>

                    <!-- Status Steps -->
                    <div class="flex justify-between w-full relative z-10">
                        <!-- Step 1: Pending -->
                        <div class="flex flex-col items-center status-step" data-status="pending">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mb-2 step-circle">
                                <span class="text-xs font-semibold text-gray-600">1</span>
                            </div>
                            <span class="text-xs text-gray-600 text-center">Pesanan<br>Diterima</span>
                        </div>

                        <!-- Step 2: Confirmed -->
                        <div class="flex flex-col items-center status-step" data-status="confirmed">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mb-2 step-circle">
                                <span class="text-xs font-semibold text-gray-600">2</span>
                            </div>
                            <span class="text-xs text-gray-600 text-center">Pembayaran<br>Dikonfirmasi</span>
                        </div>

                        <!-- Step 3: Processing -->
                        <div class="flex flex-col items-center status-step" data-status="processing">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mb-2 step-circle">
                                <span class="text-xs font-semibold text-gray-600">3</span>
                            </div>
                            <span class="text-xs text-gray-600 text-center">Sedang<br>Diproses</span>
                        </div>

                        <!-- Step 4: Ready -->
                        <div class="flex flex-col items-center status-step" data-status="ready">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mb-2 step-circle">
                                <span class="text-xs font-semibold text-gray-600">4</span>
                            </div>
                            <span class="text-xs text-gray-600 text-center">Siap<br>Disajikan</span>
                        </div>

                        <!-- Step 5: Completed -->
                        <div class="flex flex-col items-center status-step" data-status="completed">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mb-2 step-circle">
                                <span class="text-xs font-semibold text-gray-600">5</span>
                            </div>
                            <span class="text-xs text-gray-600 text-center">Pesanan<br>Selesai</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Status Display -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center px-6 py-3 rounded-full text-sm font-medium" id="current-status-badge">
                    <div class="w-2 h-2 rounded-full mr-2" id="status-indicator"></div>
                    <span id="status-text">Loading...</span>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-8">
                <h3 class="font-semibold text-gray-800 mb-4">Item Pesanan</h3>
                <div class="space-y-3">
                    @foreach($order->orderItems as $item)
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <div>
                            <span class="font-medium">{{ $item->quantity }}x {{ $item->product->nama ?? 'Item Deleted' }}</span>
                        </div>
                        <span class="text-gray-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center space-y-4">
                <button onclick="refreshStatus()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                    Refresh Status
                </button>
                <div>
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800 text-sm">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </main>

    <style>
        .bg-cream-100 { background-color: #fdf8f0; }
        
        .status-step.active .step-circle {
            background-color: #10b981;
            color: white;
        }
        
        .status-step.active span {
            color: #10b981;
            font-weight: 600;
        }
        
        /* Real-time indicator animation */
        .realtime-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
            animation: pulse 2s infinite;
            margin-left: 8px;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
    </style>

    <script>
        const orderId = {{ $order->id }};
        let currentStatus = '{{ $order->status }}';
        let currentPaymentStatus = '{{ $order->status_bayar }}';

        // Status mapping
        const statusSteps = ['pending', 'confirmed', 'processing', 'ready', 'completed'];
        const statusMessages = {
            'pending': 'Menunggu Konfirmasi Pembayaran',
            'confirmed': 'Pembayaran Dikonfirmasi',
            'processing': 'Pesanan Sedang Diproses',
            'ready': 'Pesanan Siap Disajikan',
            'completed': 'Pesanan Selesai'
        };

        const statusColors = {
            'pending': { bg: 'bg-yellow-100', text: 'text-yellow-800', indicator: 'bg-yellow-500' },
            'confirmed': { bg: 'bg-blue-100', text: 'text-blue-800', indicator: 'bg-blue-500' },
            'processing': { bg: 'bg-orange-100', text: 'text-orange-800', indicator: 'bg-orange-500' },
            'ready': { bg: 'bg-purple-100', text: 'text-purple-800', indicator: 'bg-purple-500' },
            'completed': { bg: 'bg-green-100', text: 'text-green-800', indicator: 'bg-green-500' }
        };

        function updateAllTimes() {
            const now = new Date();
            
            // Update current time in header
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const timeString = `${hours}.${minutes}`;
            
            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
            
            // WAKTU PESAN TIDAK DIUPDATE - tetap statis sesuai waktu asli pemesanan
            
            // Update estimated completion time
            const estimatedCompletionElement = document.getElementById('estimated-completion');
            if (estimatedCompletionElement) {
                let estimatedMinutes = 0;
                
                // Calculate estimated completion based on current status
                switch(currentStatus) {
                    case 'pending':
                        estimatedMinutes = 15; // 15 minutes from now
                        break;
                    case 'confirmed':
                        estimatedMinutes = 12; // 12 minutes from now
                        break;
                    case 'processing':
                        estimatedMinutes = 8; // 8 minutes from now
                        break;
                    case 'ready':
                        estimatedMinutes = 2; // 2 minutes from now
                        break;
                    case 'completed':
                        estimatedMinutes = 0; // Already completed
                        break;
                    default:
                        estimatedMinutes = 15;
                }
                
                if (currentStatus === 'completed') {
                    estimatedCompletionElement.textContent = 'Pesanan Selesai';
                    estimatedCompletionElement.className = 'font-medium text-green-600';
                } else {
                    const estimatedTime = new Date(now.getTime() + (estimatedMinutes * 60 * 1000));
                    const estHours = String(estimatedTime.getHours()).padStart(2, '0');
                    const estMinutes = String(estimatedTime.getMinutes()).padStart(2, '0');
                    
                    estimatedCompletionElement.textContent = `${estHours}:${estMinutes} (~${estimatedMinutes} menit lagi)`;
                    // Add back the real-time indicator
                    const estimatedIndicator = document.createElement('span');
                    estimatedIndicator.className = 'realtime-indicator';
                    estimatedCompletionElement.appendChild(estimatedIndicator);
                    
                    // Color coding based on urgency
                    if (estimatedMinutes <= 5) {
                        estimatedCompletionElement.className = 'font-medium text-green-600';
                    } else if (estimatedMinutes <= 10) {
                        estimatedCompletionElement.className = 'font-medium text-orange-600';
                    } else {
                        estimatedCompletionElement.className = 'font-medium text-blue-600';
                    }
                }
            }
        }

        function updateStatusDisplay(status, paymentStatus) {
            // Determine effective status
            let effectiveStatus = status;
            if (status === 'pending' && paymentStatus === 'paid') {
                effectiveStatus = 'confirmed';
            }

            // Update progress line
            const currentIndex = statusSteps.indexOf(effectiveStatus);
            const progressPercentage = currentIndex >= 0 ? (currentIndex / (statusSteps.length - 1)) * 100 : 0;
            document.getElementById('progress-line').style.width = progressPercentage + '%';

            // Update status steps
            document.querySelectorAll('.status-step').forEach((step, index) => {
                if (index <= currentIndex) {
                    step.classList.add('active');
                } else {
                    step.classList.remove('active');
                }
            });

            // Update status badge
            const colors = statusColors[effectiveStatus] || statusColors['pending'];
            const badge = document.getElementById('current-status-badge');
            const indicator = document.getElementById('status-indicator');
            const statusText = document.getElementById('status-text');

            badge.className = `inline-flex items-center px-6 py-3 rounded-full text-sm font-medium ${colors.bg} ${colors.text}`;
            indicator.className = `w-2 h-2 rounded-full mr-2 ${colors.indicator}`;
            statusText.textContent = statusMessages[effectiveStatus] || 'Status Tidak Diketahui';
        }

        function refreshStatus() {
            fetch(`/api/order-status/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentStatus = data.order.status;
                        currentPaymentStatus = data.order.status_bayar;
                        updateStatusDisplay(currentStatus, currentPaymentStatus);
                        
                        // Show notification if status changed
                        if (data.order.status !== '{{ $order->status }}' || data.order.status_bayar !== '{{ $order->status_bayar }}') {
                            showNotification('Status pesanan telah diperbarui!');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Gagal memperbarui status', 'error');
                });
        }

        function showNotification(message, type = 'success') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 ${type === 'error' ? 'bg-red-500' : 'bg-green-500'}`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Auto refresh every 10 seconds
        setInterval(refreshStatus, 10000);

        // Update all times every second
        setInterval(updateAllTimes, 1000);

        // Initial status display and time update
        document.addEventListener('DOMContentLoaded', function() {
            updateStatusDisplay(currentStatus, currentPaymentStatus);
            updateAllTimes(); // Initial time update
        });
    </script>
</body>
</html>