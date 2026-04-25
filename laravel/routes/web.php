<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard - redirect based on role
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route resource untuk kasir (hanya admin)
Route::resource('kasirs', KasirController::class)->middleware(['auth', 'verified', 'admin']);

// Route resource untuk transaksi (hanya kasir)
Route::resource('transaksis', TransaksiController::class)
    ->middleware(['auth', 'verified']);

// Route resource untuk kategori (hanya admin)
Route::resource('kategoris', KategoriController::class)->middleware(['auth', 'verified', 'admin']);

// Route resource untuk produk (hanya admin)
Route::resource('produks', ProdukController::class)->middleware(['auth', 'verified', 'admin']);

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
