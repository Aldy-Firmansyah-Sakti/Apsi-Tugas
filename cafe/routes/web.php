<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Customer\LoginPage;
use App\Livewire\Customer\HomePage;
use App\Livewire\Customer\CartPage;
use App\Livewire\Customer\PaymentPage;

// Customer Routes
Route::prefix('order')->name('customer.')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/home', HomePage::class)->name('home');
    Route::get('/cart', CartPage::class)->name('cart');
    Route::get('/payment', PaymentPage::class)->name('payment');
});

// Staff/Admin Routes (akan dibuat di fase berikutnya)
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';