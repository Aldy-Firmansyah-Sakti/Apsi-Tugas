<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Café X</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('customer.menu', ['session_id' => $sessionId]) }}" class="text-gray-500 hover:text-gray-700 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-green-800">Keranjang</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Real-time Clock -->
                    <div class="text-gray-600 font-medium" id="current-time">{{ date('H.i') }}</div>
                    
                    <div class="text-sm text-gray-600">
                        {{ $orderSession['customer_name'] }} - Meja {{ $orderSession['table_number'] }}
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(empty($cart))
            <!-- Empty Cart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Keranjang Kosong</h3>
                <p class="text-gray-500 mb-4">Belum ada item yang ditambahkan ke keranjang</p>
                <a href="{{ route('customer.menu', ['session_id' => $sessionId]) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 inline-block">
                    Pilih Menu
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100">
                            <h2 class="text-xl font-semibold text-gray-800">Item Pesanan</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-100">
                            @foreach($cart as $productId => $item)
                            <div class="p-6" id="cart-item-{{ $productId }}">
                                <div class="flex items-start space-x-4">
                                    <!-- Product Image -->
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                        @if(isset($item['foto']) && $item['foto'])
                                            <img src="{{ $item['foto'] }}" 
                                                 alt="{{ $item['name'] }}" 
                                                 class="w-full h-full object-cover"
                                                 onerror="this.src='{{ get_default_product_image() }}'">
                                        @else
                                            <img src="{{ get_default_product_image() }}" 
                                                 alt="{{ $item['name'] }}" 
                                                 class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    
                                    <!-- Product Info and Controls -->
                                    <div class="flex-1">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-3 sm:space-y-0">
                                            <!-- Product Info -->
                                            <div class="flex-1">
                                                <h3 class="font-medium text-gray-800">{{ $item['name'] }}</h3>
                                                <p class="text-sm text-gray-500">Rp {{ number_format($item['price'], 0, ',', '.') }} per item</p>
                                            </div>
                                            
                                            <!-- Controls and Total -->
                                            <div class="flex items-center justify-between sm:justify-end space-x-4">
                                                <!-- Quantity Controls -->
                                                <div class="flex items-center space-x-2 bg-gray-50 rounded-lg p-1">
                                                    <!-- Decrease Button -->
                                                    <button onclick="updateQuantity({{ $productId }}, 'decrease')" 
                                                            class="w-8 h-8 rounded-md bg-white hover:bg-gray-100 flex items-center justify-center transition duration-200 shadow-sm {{ $item['quantity'] <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                            {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    
                                                    <!-- Quantity Display -->
                                                    <span class="w-10 text-center font-medium text-gray-800 text-sm" id="quantity-{{ $productId }}">{{ $item['quantity'] }}</span>
                                                    
                                                    <!-- Increase Button -->
                                                    <button onclick="updateQuantity({{ $productId }}, 'increase')" 
                                                            class="w-8 h-8 rounded-md bg-white hover:bg-gray-100 flex items-center justify-center transition duration-200 shadow-sm">
                                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                
                                                <!-- Item Total -->
                                                <div class="text-right min-w-[80px]">
                                                    <p class="font-semibold text-gray-800" id="item-total-{{ $productId }}">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                                </div>
                                                
                                                <!-- Remove Button -->
                                                <button onclick="removeItem({{ $productId }})" 
                                                        class="w-8 h-8 rounded-md bg-red-50 hover:bg-red-100 flex items-center justify-center transition duration-200 text-red-600"
                                                        title="Hapus item">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>
                        
                        <!-- Service Fee Info -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                            <div class="flex items-start">
                                <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="text-xs text-blue-800">
                                    <p class="font-medium">Biaya Layanan 1%</p>
                                    <p>Biaya layanan akan ditambahkan ke total pesanan</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-3 mb-6" id="order-summary">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium" id="subtotal-display">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Layanan (1%)</span>
                                <span class="font-medium" id="service-fee-display">Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold">Total</span>
                                    <span class="text-lg font-bold text-green-600" id="total-display">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <form method="POST" action="{{ route('customer.checkout') }}">
                            @csrf
                            <input type="hidden" name="session_id" value="{{ $sessionId }}">
                            
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pembayaran</label>
                                <div class="space-y-2">
                                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="payment_method" value="cash" class="text-green-600 focus:ring-green-500" required>
                                        <div class="ml-3">
                                            <div class="font-medium text-gray-800">Cash</div>
                                            <div class="text-sm text-gray-500">Bayar tunai ke kasir</div>
                                        </div>
                                    </label>
                                    
                                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="payment_method" value="qris" class="text-green-600 focus:ring-green-500" required>
                                        <div class="ml-3">
                                            <div class="font-medium text-gray-800">QRIS</div>
                                            <div class="text-sm text-gray-500">Scan QR Code untuk bayar</div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" id="checkout-btn"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg font-medium transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="checkout-text">Pesan Sekarang</span>
                                <span id="checkout-loading" class="hidden">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Memproses...
                                </span>
                            </button>
                        </form>

                        <a href="{{ route('customer.menu', ['session_id' => $sessionId]) }}" 
                           class="w-full mt-3 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-6 rounded-lg font-medium transition duration-200 text-center block">
                            Tambah Item Lain
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </main>

    <style>
        .bg-cream-100 { background-color: #fdf8f0; }
    </style>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50">
        <span id="toast-message"></span>
    </div>

    <script>
        const sessionId = '{{ $sessionId }}';
        
        // Cart data for calculations
        let cartData = @json($cart);
        
        function updateQuantity(productId, action) {
            let currentQuantity = cartData[productId] ? cartData[productId].quantity : 1;
            let newQuantity;
            
            if (action === 'increase') {
                newQuantity = currentQuantity + 1;
            } else if (action === 'decrease') {
                newQuantity = Math.max(1, currentQuantity - 1);
            } else {
                // If action is a number (for backward compatibility)
                newQuantity = parseInt(action);
            }
            
            if (newQuantity < 1) return;
            
            fetch('{{ route("customer.update-cart") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    session_id: sessionId,
                    product_id: productId,
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart data
                    cartData[productId].quantity = newQuantity;
                    
                    // Update UI
                    updateCartUI(productId, newQuantity);
                    updateTotals();
                    showToast(data.message);
                } else {
                    showToast(data.error || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan', 'error');
            });
        }
        
        function removeItem(productId) {
            if (!confirm('Hapus item ini dari keranjang?')) return;
            
            fetch('{{ route("customer.remove-from-cart") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    session_id: sessionId,
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove from cart data
                    delete cartData[productId];
                    
                    // Remove from UI
                    document.getElementById('cart-item-' + productId).remove();
                    
                    // Update totals
                    updateTotals();
                    showToast(data.message);
                    
                    // Check if cart is empty
                    if (Object.keys(cartData).length === 0) {
                        location.reload(); // Reload to show empty cart message
                    }
                } else {
                    showToast(data.error || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan', 'error');
            });
        }
        
        function updateCartUI(productId, newQuantity) {
            const quantityElement = document.getElementById('quantity-' + productId);
            const itemTotalElement = document.getElementById('item-total-' + productId);
            
            if (quantityElement) {
                quantityElement.textContent = newQuantity;
            }
            
            if (itemTotalElement && cartData[productId]) {
                const itemTotal = cartData[productId].price * newQuantity;
                itemTotalElement.textContent = 'Rp ' + formatNumber(itemTotal);
            }
            
            // Update decrease button state
            const decreaseButton = document.querySelector(`#cart-item-${productId} button[onclick*="decrease"]`);
            if (decreaseButton) {
                if (newQuantity <= 1) {
                    decreaseButton.classList.add('opacity-50', 'cursor-not-allowed');
                    decreaseButton.disabled = true;
                } else {
                    decreaseButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    decreaseButton.disabled = false;
                }
            }
        }
        
        function updateTotals() {
            let subtotal = 0;
            
            // Calculate new subtotal
            for (let productId in cartData) {
                const item = cartData[productId];
                subtotal += item.price * item.quantity;
            }
            
            const serviceFee = subtotal * 0.01;
            const total = subtotal + serviceFee;
            
            // Update UI
            document.getElementById('subtotal-display').textContent = 'Rp ' + formatNumber(subtotal);
            document.getElementById('service-fee-display').textContent = 'Rp ' + formatNumber(serviceFee);
            document.getElementById('total-display').textContent = 'Rp ' + formatNumber(total);
        }
        
        function formatNumber(number) {
            return new Intl.NumberFormat('id-ID').format(Math.round(number));
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
        
        // Handle checkout form submission
        document.addEventListener('DOMContentLoaded', function() {
            const checkoutForm = document.querySelector('form[action="{{ route("customer.checkout") }}"]');
            const checkoutBtn = document.getElementById('checkout-btn');
            const checkoutText = document.getElementById('checkout-text');
            const checkoutLoading = document.getElementById('checkout-loading');
            
            if (checkoutForm) {
                checkoutForm.addEventListener('submit', function() {
                    checkoutBtn.disabled = true;
                    checkoutText.classList.add('hidden');
                    checkoutLoading.classList.remove('hidden');
                });
            }
        });

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