<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    // Ambil isi keranjang user
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json($cartItems);
    }

    // Tambah produk ke keranjang
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Validasi stok
        if ($request->quantity > $product->stock) {
            return response()->json(['error' => 'Stok tidak cukup'], 400);
        }

        $cartItem = Cart::where('user_id', auth()->id())
                        ->where('product_id', $product->id)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json(['success' => 'Produk ditambahkan ke keranjang']);
    }

    // Update jumlah produk
    public function updateQuantity(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);
        $product = Product::findOrFail($cartItem->product_id);

        if ($request->quantity > $product->stock) {
            return response()->json(['error' => 'Stok tidak cukup'], 400);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json(['success' => 'Jumlah produk diperbarui']);
    }

    // Hapus produk dari keranjang
    public function removeItem($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return response()->json(['success' => 'Produk dihapus dari keranjang']);
    }
}