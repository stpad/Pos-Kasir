<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Produk;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produks,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->product_id);

        if ($request->quantity > $produk->stok) {
            return response()->json(['error' => 'Stok tidak cukup!'], 400);
        }

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $produk->id)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $request->quantity;
            if ($newQty > $produk->stok) {
                return response()->json(['error' => 'Stok tidak cukup!'], 400);
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            Cart::create([
                'user_id'    => auth()->id(),
                'product_id' => $produk->id,
                'quantity'   => $request->quantity,
            ]);
        }

        return response()->json([
            'success' => 'Produk ditambahkan!',
            'cart'    => $this->getCartData(),
        ]);
    }

    public function updateQuantity(Request $request, $id)
    {
        $cartItem = Cart::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $produk = Produk::findOrFail($cartItem->product_id);

        if ($request->quantity <= 0) {
            $cartItem->delete();
        } else {
            if ($request->quantity > $produk->stok) {
                return response()->json(['error' => 'Stok tidak cukup!'], 400);
            }
            $cartItem->update(['quantity' => $request->quantity]);
        }

        return response()->json([
            'success' => 'Keranjang diperbarui.',
            'cart'    => $this->getCartData(),
        ]);
    }

    public function removeItem($id)
    {
        Cart::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail()
            ->delete();

        return response()->json([
            'success' => 'Produk dihapus.',
            'cart'    => $this->getCartData(),
        ]);
    }

    public function index()
    {
        return response()->json($this->getCartData());
    }

    private function getCartData()
    {
        $items = Cart::with('produk')
            ->where('user_id', auth()->id())
            ->get()
            ->map(fn($item) => [
                'id'       => $item->id,
                'nama'     => $item->produk->nama,
                'harga'    => $item->produk->harga,
                'stok'     => $item->produk->stok,
                'quantity' => $item->quantity,
                'subtotal' => $item->produk->harga * $item->quantity,
            ]);

        return [
            'items' => $items,
            'total' => $items->sum('subtotal'),
            'count' => $items->sum('quantity'),
        ];
    }
}