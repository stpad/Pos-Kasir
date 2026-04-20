<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard (gabungan logic)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Dashboard role
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })->name('admin.dashboard');

    Route::get('/cashier/dashboard', function () {
        return view('dashboard.cashier');
    })->name('cashier.dashboard');

    // CART (dari branch kamu)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
});

// Kasir (akses login)
Route::resource('kasirs', KasirController::class)->middleware(['auth', 'verified']);

// Kategori (admin only)
Route::resource('kategoris', KategoriController::class)->middleware(['auth', 'verified', 'admin']);

// Produk (admin only)
Route::resource('produks', ProdukController::class)->middleware(['auth', 'verified', 'admin']);

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';