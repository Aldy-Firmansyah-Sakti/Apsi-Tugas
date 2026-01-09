<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - Café X</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center h-16">
                <h1 class="text-2xl font-bold text-green-800">Café X</h1>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
            <!-- Success Icon -->
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Pesanan Berhasil!</h2>
            <p class="text-gray-600 mb-8">Terima kasih telah memesan di Café X</p>

            <!-- Order Details -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Kode Pesanan:</span>
                        <span class="font-semibold text-gray-800">{{ $order->kode_order }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Nama Pemesan:</span>
                        <span class="font-semibold text-gray-800">{{ $order->nama_pemesan }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Metode Pembayaran:</span>
                        <span class="font-semibold text-gray-800">{{ ucfirst($order->metode_pembayaran) }}</span>
                    </div>
                    <hr class="border-gray-300">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Subtotal:</span>
                        <span class="font-medium text-gray-800">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Biaya Layanan (1%):</span>
                        <span class="font-medium text-gray-800">Rp {{ number_format($order->service_fee, 0, ',', '.') }}</span>
                    </div>
                    <hr class="border-gray-300">
                    <div class="flex justify-between">
                        <span class="text-lg font-semibold text-gray-800">Total:</span>
                        <span class="text-lg font-bold text-green-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="text-left mb-8">
                <h3 class="font-semibold text-gray-800 mb-3">Langkah Selanjutnya:</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    @if($order->metode_pembayaran == 'cash')
                        <p>• Silakan menuju kasir untuk melakukan pembayaran</p>
                        <p>• Tunjukkan kode pesanan: <strong>{{ $order->kode_order }}</strong></p>
                    @else
                        <p>• Silakan scan QR Code yang tersedia di meja untuk pembayaran</p>
                        <p>• Atau tunjukkan kode pesanan ke kasir: <strong>{{ $order->kode_order }}</strong></p>
                    @endif
                    <p>• Pesanan akan diproses setelah pembayaran dikonfirmasi</p>
                    <p>• Estimasi waktu penyajian: 10-15 menit</p>
                </div>
            </div>

            <!-- Status -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-8">
                <div class="flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-yellow-800 font-medium">Status: Menunggu Pembayaran</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <a href="{{ route('home') }}" 
                   class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg font-medium transition duration-200 inline-block">
                    Pesan Lagi
                </a>
                
                <button onclick="window.print()" 
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-6 rounded-lg font-medium transition duration-200">
                    Cetak Struk
                </button>
            </div>
        </div>
    </main>

    <style>
        .bg-cream-100 { background-color: #fdf8f0; }
        
        @media print {
            body * {
                visibility: hidden;
            }
            .bg-white, .bg-white * {
                visibility: visible;
            }
            .bg-white {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            button {
                display: none !important;
            }
        }
    </style>
</body>
</html>