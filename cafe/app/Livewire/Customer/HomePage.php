<?php

namespace App\Livewire\Customer;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class HomePage extends Component
{
    public $customerName;
    public $tableNumber;
    public $selectedCategory = null;
    public $categories = [];
    public $products = [];
    public $cart = [];

    public function mount()
    {
        // Check session
        if (!session()->has('customer_name') || !session()->has('table_number')) {
            return redirect()->route('customer.login');
        }

        $this->customerName = session('customer_name');
        $this->tableNumber = session('table_number');
        
        // Load categories and products
        $this->categories = Category::active()->ordered()->get();
        $this->loadProducts();
        
        // Load cart from session
        $this->cart = session('cart', []);
    }

    public function loadProducts()
    {
        $query = Product::with('category')->available();

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        $this->products = $query->get();
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->loadProducts();
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        
        if (!$product) return;

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'product_id' => $product->id,
                'nama' => $product->nama,
                'harga' => $product->harga,
                'foto' => $product->foto,
                'quantity' => 1,
                'notes' => '',
            ];
        }

        session(['cart' => $this->cart]);
        
        $this->dispatch('cart-updated');
        $this->dispatch('notify', message: 'Produk ditambahkan ke keranjang');
    }

    public function render()
    {
        return view('livewire.customer.home-page')->layout('layouts.customer');
    }
}