<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('kategoris', KategoriController::class);
Route::resource('produks', ProdukController::class);
Route::get('transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
Route::post('transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
