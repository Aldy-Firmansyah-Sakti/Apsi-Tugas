<div class="min-h-screen bg-gray-50 pb-32">
    <!-- Header -->
    <div class="bg-white shadow-sm p-4 flex items-center gap-4">
        <a href="{{ route('customer.home') }}" class="text-2xl">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-xl font-bold">Your Order</h1>
    </div>

    <!-- Cart Items -->
    <div class="p-4 space-y-4">
        @forelse($cart as $productId => $item)
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="flex items-start gap-4">
                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex-shrink-0"></div>
                    
                    <div class="flex-1">
                        <h3 class="font-semibold mb-1">{{ $item['nama'] }}</h3>
                        <p class="text-green-700 font-bold">{{ format_rupiah($item['harga']) }}</p>
                        
                        <!-- Notes -->
                        <button 
                            onclick="document.getElementById('notes-{{ $productId }}').classList.toggle('hidden')"
                            class="text-sm text-gray-600 mt-2 flex items-center gap-1"
                        >
                            <i class="fas fa-sticky-note"></i> Notes
                        </button>
                        <textarea 
                            id="notes-{{ $productId }}"
                            wire:model.blur="cart.{{ $productId }}.notes"
                            wire:change="updateNotes({{ $productId }}, $event.target.value)"
                            class="hidden w-full mt-2 p-2 border rounded-lg text-sm"
                            placeholder="Tambahkan catatan..."
                            rows="2"
                        >{{ $item['notes'] }}</textarea>
                    </div>

                    <!-- Quantity Controls -->
                    <div class="flex items-center gap-3">
                        <button 
                            wire:click="updateQuantity({{ $productId }}, 'decrement')"
                            class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center"
                        >
                            <i class="fas fa-minus text-sm"></i>
                        </button>
                        <span class="font-semibold">{{ $item['quantity'] }}</span>
                        <button 
                            wire:click="updateQuantity({{ $productId }}, 'increment')"
                            class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center"
                        >
                            <i class="fas fa-plus text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Keranjang masih kosong</p>
            </div>
        @endforelse
    </div>

    <!-- Summary (Fixed Bottom) -->
    @if(!empty($cart))
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg p-4">
            <div class="max-w-2xl mx-auto">
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span>Price</span>
                        <span>{{ format_rupiah($subtotal) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Service Fee</span>
                        <span>{{ format_rupiah($serviceFee) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-2">
                        <span>Total payment</span>
                        <span>{{ format_rupiah($total) }}</span>
                    </div>
                </div>

                <button 
                    wire:click="proceedToPayment"
                    class="w-full bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800"
                >
                    Make an order
                </button>
            </div>
        </div>
    @endif
</div>