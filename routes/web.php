<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Guest routes (not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User routes
    Route::middleware('role:user')->group(function () {
        Route::get('/', [UserController::class, 'home'])->name('user.home');
        Route::post('/cart/add', [UserController::class, 'addToCart'])->name('cart.add');
        Route::get('/cart', [UserController::class, 'cart'])->name('user.cart');
        Route::post('/cart/update/{id}', [UserController::class, 'updateCart'])->name('cart.update');
        Route::delete('/cart/remove/{id}', [UserController::class, 'removeFromCart'])->name('cart.remove');
        Route::post('/checkout', [UserController::class, 'checkout'])->name('user.checkout');
        Route::get('/orders', [UserController::class, 'orders'])->name('user.orders');
    });

    // Petugas (Staff) routes - TEMPORARY TEST WITHOUT MIDDLEWARE
    Route::prefix('petugas')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\PetugasController::class, 'dashboard'])->name('petugas.dashboard');
        Route::get('/order/{id}', [App\Http\Controllers\PetugasController::class, 'showOrder'])->name('petugas.order');
        Route::post('/order/{id}/accept', [App\Http\Controllers\PetugasController::class, 'acceptOrder'])->name('petugas.order.accept');
        Route::post('/order/{id}/cancel', [App\Http\Controllers\PetugasController::class, 'cancelOrder'])->name('petugas.order.cancel');
    });

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Products
        Route::get('/products', [App\Http\Controllers\AdminController::class, 'products'])->name('admin.products');
        Route::get('/products/create', [App\Http\Controllers\AdminController::class, 'createProduct'])->name('admin.products.create');
        Route::post('/products', [App\Http\Controllers\AdminController::class, 'storeProduct'])->name('admin.products.store');
        Route::get('/products/{id}/edit', [App\Http\Controllers\AdminController::class, 'editProduct'])->name('admin.products.edit');
        Route::post('/products/{id}', [App\Http\Controllers\AdminController::class, 'updateProduct'])->name('admin.products.update');
        Route::delete('/products/{id}', [App\Http\Controllers\AdminController::class, 'deleteProduct'])->name('admin.products.delete');
        
        // Users
        Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/create', [App\Http\Controllers\AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::delete('/users/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::post('/users/{id}/role', [App\Http\Controllers\AdminController::class, 'changeRole'])->name('admin.users.role');
        
        // Orders
        Route::get('/orders', [App\Http\Controllers\AdminController::class, 'orders'])->name('admin.orders');
        Route::get('/orders/{id}', [App\Http\Controllers\AdminController::class, 'showOrder'])->name('admin.order.detail');
    });
});