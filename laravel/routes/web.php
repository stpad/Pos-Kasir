<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PembayaranController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('kategoris', KategoriController::class);
Route::resource('produks', ProdukController::class);
Route::get('pembayaran', [PembayaranController::class, 'create'])->name('pembayaran.create');
Route::post('pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
