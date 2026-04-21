<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; // ← TAMBAHKAN INI
use App\Models\Produk;

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

    // CART
    Route::get('/cart', [CartController::class, 'showPage'])->name('cart.index');
    Route::get('/cart/data', [CartController::class, 'index'])->name('cart.data');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');

    // POS
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
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


Route::post('/cart/clear', [CartController::class, 'clearUserCart'])->name('cart.clear');
// ✅ PERBAIKI ROUTE CHECK STOK
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
})->middleware(['auth', 'verified'])->name('check.stok.batch');

require __DIR__.'/auth.php';