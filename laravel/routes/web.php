<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PembayaranController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('kategoris', KategoriController::class);
Route::get('pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
