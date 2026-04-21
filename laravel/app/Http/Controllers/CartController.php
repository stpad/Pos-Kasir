<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Produk;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:produks,id',
                'quantity'   => 'required|integer|min:1',
            ]);

            $produk = Produk::findOrFail($request->product_id);

            // Cek stok
            if ($request->quantity > $produk->stok) {
                return response()->json(['error' => 'Stok tidak cukup!'], 400);
            }

            // Cek apakah sudah ada di cart
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
                'success' => true,
                'message' => 'Produk ditambahkan!',
                'cart'    => $this->getCartData(),
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function showPage()
    {
        $data = $this->getCartData();
        $items = collect($data['items']);
        return view('kasirs.cart', compact('items'));
    }

    public function updateQuantity(Request $request, $id)
    {
        try {
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
                'success' => true,
                'message' => 'Keranjang diperbarui.',
                'cart'    => $this->getCartData(),
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function removeItem($id)
    {
        try {
            Cart::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail()
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produk dihapus.',
                'cart'    => $this->getCartData(),
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
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
                'id'         => $item->id,
                'product_id' => $item->product_id,
                'nama'       => $item->produk->nama,
                'harga'      => $item->produk->harga,
                'stok'       => $item->produk->stok,
                'quantity'   => $item->quantity,
                'subtotal'   => $item->produk->harga * $item->quantity,
            ]);

        return [
            'items' => $items,
            'total' => $items->sum('subtotal'),
            'count' => $items->sum('quantity'),
        ];
    }

    public function clearUserCart()
{
    Cart::where('user_id', auth()->id())->delete();
    return response()->json(['success' => true]);
}
}