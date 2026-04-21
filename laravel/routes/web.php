<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', fn() => redirect()->route('dashboard'));

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // API endpoints for dashboard
    Route::prefix('api')->group(function () {
        Route::get('/sales-chart', [DashboardController::class, 'salesChart'])->name('api.sales.chart');
        Route::get('/quick-stats', [DashboardController::class, 'quickStats'])->name('api.quick.stats');
    });
    
    // Shopping Cart
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'addToCart'])->name('add');
        Route::post('/update/{id}', [CartController::class, 'updateQuantity'])->name('update');
        Route::delete('/remove/{id}', [CartController::class, 'removeItem'])->name('remove');
    });
    
    // Direct role dashboards (if needed)
    Route::view('/admin/dashboard', 'dashboard.admin')->name('admin.dashboard');
    Route::view('/cashier/dashboard', 'dashboard.cashier')->name('cashier.dashboard');
    
    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin only resources
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::resource('kategoris', KategoriController::class);
    Route::resource('produks', ProdukController::class);
});

// Kasir resource (authenticated but not necessarily admin)
Route::resource('kasirs', KasirController::class)->middleware(['auth', 'verified']);

// Auth routes
require __DIR__.'/auth.php';