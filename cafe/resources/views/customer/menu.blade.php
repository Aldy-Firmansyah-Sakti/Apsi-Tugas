<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Café X</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Preload critical images -->
    @foreach($categories->take(1) as $categoryProducts)
        @foreach($categoryProducts->take(3) as $product)
            @if($product->image_url)
                <link rel="preload" as="image" href="{{ $product->image_url }}">
            @endif
        @endforeach
    @endforeach
</head>
<body class="bg-cream-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-green-800">Café X</h1>
                    <div class="ml-4 text-sm text-gray-600">
                        {{ $orderSession['customer_name'] }} - Meja {{ $orderSession['table_number'] }}
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Real-time Clock -->
                    <div class="text-gray-600 font-medium" id="current-time">{{ date('H.i') }}</div>
                    
                    <button onclick="viewCart()" class="relative bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                        Keranjang
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search Bar -->
        <div class="mb-8">
            <div class="relative max-w-md mx-auto">
                <input type="text" 
                       id="search-menu"
                       placeholder="Cari menu..." 
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="mb-8">
            <div class="flex flex-wrap justify-center gap-3">
                <button onclick="filterByCategory('all')" 
                        class="category-filter-btn active px-6 py-3 rounded-full font-medium transition duration-200 bg-green-600 text-white hover:bg-green-700">
                    All
                </button>
                <button onclick="filterByCategory('drinks')" 
                        class="category-filter-btn px-6 py-3 rounded-full font-medium transition duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300">
                    Drinks
                </button>
                <button onclick="filterByCategory('snacks')" 
                        class="category-filter-btn px-6 py-3 rounded-full font-medium transition duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300">
                    Snacks
                </button>
                <button onclick="filterByCategory('maincourse')" 
                        class="category-filter-btn px-6 py-3 rounded-full font-medium transition duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300">
                    Main Course
                </button>
            </div>
        </div>

        <!-- Menu Categories -->
        @foreach($categories as $categoryName => $categoryProducts)
        <div class="mb-12 category-section" data-category="{{ strtolower($categoryName) }}">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $categoryName }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categoryProducts as $product)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden menu-item hover:shadow-md" 
                     data-name="{{ strtolower($product->nama) }}" 
                     data-category="{{ strtolower($categoryName) }}">
                    <!-- Product Image -->
                    <div class="h-48 bg-gray-200 relative overflow-hidden">
                        <div class="image-placeholder" id="placeholder-{{ $product->id }}"></div>
                        <img src="{{ $product->image_url }}" 
                             alt="{{ $product->nama }}" 
                             class="opacity-0"
                             loading="lazy"
                             decoding="async"
                             onload="this.style.opacity='1'; document.getElementById('placeholder-{{ $product->id }}').style.display='none';"
                             onerror="this.src='{{ get_default_product_image() }}'; this.style.opacity='1'; document.getElementById('placeholder-{{ $product->id }}').style.display='none';">
                    </div>

                    <!-- Product Info -->
                    <div class="p-6">
                        <h3 class="font-semibold text-gray-800 mb-2">{{ $product->nama }}</h3>
                        @if($product->deskripsi)
                            <p class="text-sm text-gray-600 mb-3">{{ $product->deskripsi }}</p>
                        @endif
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-green-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            <div class="flex items-center space-x-2">
                                <button onclick="changeQuantity({{ $product->id }}, -1)" class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <span id="qty-{{ $product->id }}" class="w-8 text-center font-medium">1</span>
                                <button onclick="changeQuantity({{ $product->id }}, 1)" class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button onclick="addToCart({{ $product->id }})" class="w-full mt-4 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg font-medium transition duration-200">
                            Tambah ke Keranjang
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </main>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50">
        <span id="toast-message"></span>
    </div>

    <style>
        .bg-cream-100 { background-color: #fdf8f0; }
        
        .category-filter-btn {
            transition: all 0.2s ease-in-out;
        }
        
        .category-filter-btn.active {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(34, 197, 94, 0.3);
        }
        
        .category-filter-btn:hover {
            transform: translateY(-1px);
        }
        
        /* Prevent layout shift and improve image loading */
        .menu-item {
            transition: transform 0.2s ease-in-out;
            will-change: transform;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }
        
        .menu-item:hover {
            transform: translateY(-2px);
        }
        
        /* Ensure consistent image container size */
        .menu-item .h-48 {
            min-height: 12rem;
            max-height: 12rem;
            position: relative;
            overflow: hidden;
        }
        
        /* Smooth image loading */
        .menu-item img {
            transition: opacity 0.3s ease-in-out;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Stable placeholder */
        .image-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        /* Reduce animation for better performance */
        * {
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
        }
        
        /* Grid stability */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }
        
        @media (min-width: 768px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (min-width: 1024px) {
            .grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>

    <script>
        const sessionId = '{{ $sessionId }}';
        let cartCount = 0;

        function changeQuantity(productId, change) {
            const qtyElement = document.getElementById(`qty-${productId}`);
            let currentQty = parseInt(qtyElement.textContent);
            currentQty = Math.max(1, currentQty + change);
            qtyElement.textContent = currentQty;
        }

        function addToCart(productId) {
            const quantity = parseInt(document.getElementById(`qty-${productId}`).textContent);
            
            fetch('{{ route("customer.add-to-cart") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    session_id: sessionId,
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cartCount += quantity;
                    document.getElementById('cart-count').textContent = cartCount;
                    showToast(data.message);
                    // Reset quantity to 1
                    document.getElementById(`qty-${productId}`).textContent = '1';
                } else {
                    showToast(data.error, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan', 'error');
            });
        }

        function viewCart() {
            window.location.href = `{{ route('customer.cart', ['session_id' => ':sessionId']) }}`.replace(':sessionId', sessionId);
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

        // Category filter functionality (optimized)
        function filterByCategory(category) {
            const categoryButtons = document.querySelectorAll('.category-filter-btn');
            const categorySections = document.querySelectorAll('.category-section');
            const menuItems = document.querySelectorAll('.menu-item');
            
            // Use requestAnimationFrame for smooth animations
            requestAnimationFrame(() => {
                // Update active button
                categoryButtons.forEach(btn => {
                    btn.classList.remove('active', 'bg-green-600', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });
                
                event.target.classList.remove('bg-gray-200', 'text-gray-700');
                event.target.classList.add('active', 'bg-green-600', 'text-white');
                
                // Clear search when filtering by category
                document.getElementById('search-menu').value = '';
                
                if (category === 'all') {
                    // Show all categories and items
                    categorySections.forEach(section => {
                        section.style.display = 'block';
                    });
                    menuItems.forEach(item => {
                        item.style.display = 'block';
                    });
                } else {
                    // Hide all sections first
                    categorySections.forEach(section => {
                        section.style.display = 'none';
                    });
                    
                    // Show only selected category
                    const targetSection = document.querySelector(`[data-category="${category}"]`);
                    if (targetSection) {
                        targetSection.style.display = 'block';
                    }
                    
                    // Show all items in the selected category
                    menuItems.forEach(item => {
                        const itemCategory = item.getAttribute('data-category');
                        if (itemCategory === category) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                }
            });
        }

        // Debounced search for better performance
        let searchTimeout;
        document.getElementById('search-menu').addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchTerm = e.target.value.toLowerCase();
                const menuItems = document.querySelectorAll('.menu-item');
                
                requestAnimationFrame(() => {
                    menuItems.forEach(item => {
                        const itemName = item.getAttribute('data-name');
                        if (itemName.includes(searchTerm)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }, 150); // Debounce 150ms
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