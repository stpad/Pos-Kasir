<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        
        $transaksis = Transaksi::with(['user', 'items.produk'])
            ->when($search, function($query) use ($search) {
                $query->where('kode_transaksi', 'like', "%{$search}%")
                      ->orWhereHas('user', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(12);

        return view('transaksis.index', compact('transaksis', 'search'));
    }

    /**
     * Show the form for creating new transaction.
     */
    public function create(Request $request)
    {
        $produk = \App\Models\Produk::where('stok', '>', 0)
            ->paginate(20);
        
        return view('transaksis.create', compact('produk'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        // Accept both array formats: items[][produk_id] or items[id][produk_id]
        $itemsInput = $request->items;
        
        // Normalize to array format
        $items = [];
        if (isset($itemsInput[0]) && isset($itemsInput[0]['produk_id'])) {
            // Format: items[0][produk_id], items[0][jumlah]
            foreach ($itemsInput as $item) {
                if (isset($item['produk_id']) && isset($item['jumlah'])) {
                    $items[] = $item;
                }
            }
        } else {
            // Format: items[id][produk_id], items[id][jumlah]
            foreach ($itemsInput as $key => $item) {
                if (isset($item['produk_id']) && isset($item['jumlah'])) {
                    $items[] = $item;
                }
            }
        }

        if (empty($items)) {
            return back()->with('error', 'Pilih minimal satu produk!');
        }

        $request->merge(['items' => $items]);
        
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'jumlah_bayar' => 'required|integer|min:0',
        ]);

        $totalHarga = 0;
        $itemsData = [];

        foreach ($items as $item) {
            $produk = \App\Models\Produk::find($item['produk_id']);
            $subtotal = $produk->harga * $item['jumlah'];
            $totalHarga += $subtotal;
            
            $itemsData[] = [
                'produk_id' => $item['produk_id'],
                'jumlah' => $item['jumlah'],
                'harga_saat_transaksi' => $produk->harga,
                'subtotal' => $subtotal,
            ];
        }

        $jumlahBayar = $request->jumlah_bayar;
        $kembalian = $jumlahBayar - $totalHarga;

        if ($kembalian < 0) {
            return back()->with('error', 'Jumlah pembayaran kurang!');
        }

        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'kode_transaksi' => Transaksi::generateKode(),
            'total_harga' => $totalHarga,
            'jumlah_bayar' => $jumlahBayar,
            'kembalian' => $kembalian,
            'status' => 'selesai',
        ]);

        foreach ($itemsData as $item) {
            $transaksi->items()->create($item);
            
            // Kurangi stok produk
            $produk = \App\Models\Produk::find($item['produk_id']);
            $produk->decrement('stok', $item['jumlah']);
        }

        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'items.produk']);
        return view('transaksis.show', compact('transaksi'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil dihapus');
    }
}