<?php

namespace App\Livewire\Customer;

use App\Models\Table;
use Livewire\Component;

class CartPage extends Component
{
    public $cart = [];
    public $subtotal = 0;
    public $serviceFee = 0;
    public $total = 0;

    public function mount()
    {
        if (!session()->has('customer_name') || !session()->has('table_number')) {
            return redirect()->route('customer.login');
        }

        $this->cart = session('cart', []);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->subtotal = 0;
        
        foreach ($this->cart as $item) {
            $this->subtotal += $item['harga'] * $item['quantity'];
        }

        $this->serviceFee = calculate_service_fee($this->subtotal);
        $this->total = $this->subtotal + $this->serviceFee;
    }

    public function updateQuantity($productId, $action)
    {
        if (!isset($this->cart[$productId])) return;

        if ($action === 'increment') {
            $this->cart[$productId]['quantity']++;
        } elseif ($action === 'decrement') {
            if ($this->cart[$productId]['quantity'] > 1) {
                $this->cart[$productId]['quantity']--;
            } else {
                unset($this->cart[$productId]);
            }
        }

        session(['cart' => $this->cart]);
        $this->calculateTotal();
    }

    public function updateNotes($productId, $notes)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['notes'] = $notes;
            session(['cart' => $this->cart]);
        }
    }

    public function removeItem($productId)
    {
        unset($this->cart[$productId]);
        session(['cart' => $this->cart]);
        $this->calculateTotal();
    }

    public function proceedToPayment()
    {
        if (empty($this->cart)) {
            $this->dispatch('notify', message: 'Keranjang masih kosong');
            return;
        }

        // Simpan total ke session
        session([
            'order_subtotal' => $this->subtotal,
            'order_service_fee' => $this->serviceFee,
            'order_total' => $this->total,
        ]);

        return redirect()->route('customer.payment');
    }

    public function render()
    {
        return view('livewire.customer.cart-page')->layout('layouts.customer');
    }
}