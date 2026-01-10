<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Customer\OrderController;

// Customer Routes (No Authentication Required)
Route::get('/', [OrderController::class, 'welcome'])->name('home');
Route::get('/customer/order', [OrderController::class, 'index'])->name('customer.order');
Route::post('/customer/start-order', [OrderController::class, 'startOrder'])->name('customer.start-order');
Route::get('/customer/menu/{session_id}', [OrderController::class, 'menu'])->name('customer.menu');
Route::post('/customer/add-to-cart', [OrderController::class, 'addToCart'])->name('customer.add-to-cart');
Route::get('/customer/cart/{session_id}', [OrderController::class, 'cart'])->name('customer.cart');
Route::post('/customer/update-cart', [OrderController::class, 'updateCart'])->name('customer.update-cart');
Route::post('/customer/remove-from-cart', [OrderController::class, 'removeFromCart'])->name('customer.remove-from-cart');
Route::post('/customer/checkout', [OrderController::class, 'checkout'])->name('customer.checkout');
Route::get('/customer/order-status/{id}', [OrderController::class, 'orderStatus'])->name('customer.order-status');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    // Protected admin routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/search', [AdminDashboardController::class, 'search'])->name('search');
        Route::resource('/menu', MenuController::class);
        
        // Order management routes
        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::patch('/orders/{order}/confirm-payment', [\App\Http\Controllers\Admin\OrderController::class, 'confirmPayment'])->name('orders.confirm-payment');
        Route::patch('/orders/{order}/cancel', [\App\Http\Controllers\Admin\OrderController::class, 'cancelOrder'])->name('orders.cancel');
        
        Route::get('/history', [\App\Http\Controllers\Admin\HistoryController::class, 'index'])->name('history.index');
    });
});

// Legacy Livewire routes (keep for compatibility)
use App\Livewire\Customer\LoginPage;
use App\Livewire\Customer\HomePage;
use App\Livewire\Customer\CartPage;
use App\Livewire\Customer\PaymentPage;

Route::prefix('order')->name('livewire.customer.')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/home', HomePage::class)->name('home');
    Route::get('/cart', CartPage::class)->name('cart');
    Route::get('/payment', PaymentPage::class)->name('payment');
});

// Staff/Admin Routes (legacy)
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';