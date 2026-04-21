<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Produk;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Role dashboards
    Route::view('/admin/dashboard', 'dashboard.admin')->name('admin.dashboard');
    Route::view('/cashier/dashboard', 'dashboard.cashier')->name('cashier.dashboard');

    // POS
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');

    // Cart
    Route::get('/cart', [CartController::class, 'showPage'])->name('cart.index');
    Route::get('/cart/data', [CartController::class, 'index'])->name('cart.data');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clearUserCart'])->name('cart.clear');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Check stok batch
    Route::post('/check-stok-batch', function (Request $request) {
        try {
            $items = $request->input('items', []);

            if (empty($items)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada item untuk dicek'
                ], 400);
            }

            foreach ($items as $item) {
                $produk = Produk::find($item['id']);

                if (!$produk) {
                    return response()->json([
                        'success' => false,
                        'message' => "Produk tidak ditemukan!"
                    ], 400);
                }

                if ($produk->stok < $item['qty']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok {$produk->nama} tidak mencukupi! (Stok: {$produk->stok}, Diminta: {$item['qty']})"
                    ], 400);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Stok tersedia'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    })->name('check.stok.batch');
});

// Kasir
Route::resource('kasirs', KasirController::class)->middleware(['auth', 'verified']);

// Admin only
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::resource('kategoris', KategoriController::class);
    Route::resource('produks', ProdukController::class);
});

require __DIR__.'/auth.php';