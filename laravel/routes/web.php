<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KasirController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard - redirect based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user && $user->role === 'admin') {
        return view('dashboard');
    }
    return redirect()->route('kasirs.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route resource untuk kasir (semua user yang login)
Route::resource('kasirs', KasirController::class)->middleware(['auth', 'verified']);

// Route resource untuk kategori (hanya admin)
Route::resource('kategoris', KategoriController::class)->middleware(['auth', 'verified', 'admin']);

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
