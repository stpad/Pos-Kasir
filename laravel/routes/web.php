<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KasirController;

Route::get('/dashboard', [KasirController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::resource('kategoris', KategoriController::class);
Route::resource('kasirs', KasirController::class);

require __DIR__.'/auth.php';
