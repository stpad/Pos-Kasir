<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk setiap role
Route::get('/admin/dashboard', function () {
    return view('dashboard.admin');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::get('/cashier/dashboard', function () {
    return view('dashboard.cashier');
})->middleware(['auth', 'verified'])->name('cashier.dashboard');

// Default dashboard (redirect based on role)
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('cashier.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
