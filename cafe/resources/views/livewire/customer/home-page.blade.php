<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-green-700 text-white p-6 rounded-b-3xl">
        <h1 class="text-4xl font-bold mb-2">Cafe X</h1>
        <p class="text-lg">Welcome, {{ $customerName }}</p>
        <p class="text-sm opacity-90">let's order some food & drink!</p>
    </div>

    <!-- Categories -->
    <div class="px-4 py-6">
        <div class="flex gap-3 overflow-x-auto pb-2">
            <button 
                wire:click="selectCategory(null)"
                class="px-6 py-2 rounded-full whitespace-nowrap {{ !$selectedCategory ? 'bg-green-700 text-white' : 'bg-white text-gray-700' }} border border-gray-300"
            >
                All
            </button>
            @foreach($categories as $category)
                <button 
                    wire:click="selectCategory({{ $category->id }})"
                    class="px-6 py-2 rounded-full whitespace-nowrap {{ $selectedCategory == $category->id ? 'bg-green-700 text-white' : 'bg-white text-gray-700' }} border border-gray-300"
                >
                    {{ $category->nama }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Products Grid -->
    <div class="px-4 pb-24">
        <div class="grid grid-cols-2 gap-4" wire:key="products-grid">
            @foreach($products as $product)
                <div wire:key="product-{{ $product->id }}" class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <div class="h-40 bg-gray-200 relative">
                        @if($product->foto)
                            <img src="{{ $product->foto }}" alt="{{ $product->nama }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-3">
                        <h3 class="font-semibold text-sm mb-1">{{ $product->nama }}</h3>
                        <p class="text-green-700 font-bold text-sm mb-2">{{ format_rupiah($product->harga) }}</p>
                        <button 
                            wire:click="addToCart({{ $product->id }})"
                            class="w-full bg-green-700 text-white py-2 rounded-lg text-sm hover:bg-green-800"
                        >
                            Add to Cart
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Floating Cart Button -->
    <div class="fixed bottom-6 right-6">
        <a href="{{ route('customer.cart') }}" class="relative">
            <div class="bg-green-700 text-white p-4 rounded-full shadow-lg hover:bg-green-800">
                <i class="fas fa-shopping-cart text-2xl"></i>
                @if(count($cart) > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center">
                        {{ count($cart) }}
                    </span>
                @endif
            </div>
        </a>
    </div>
</div>