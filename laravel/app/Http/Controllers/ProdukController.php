<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $lowStockThreshold = 5;
        $produks = Produk::with('kategori')->get();
        $lowStockProduks = $produks->filter(fn ($produk) => $produk->stok_awal <= $lowStockThreshold);

        return view('produks.index', compact('produks', 'lowStockProduks', 'lowStockThreshold'));
    }

    public function create()
    {
        return view('produks.create', ['kategoris' => Kategori::all()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok_awal' => 'required|integer|min:0',
        ]);

        Produk::create($validated);

        return redirect()->route('produks.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        return view('produks.edit', [
            'produk' => $produk,
            'kategoris' => Kategori::all(),
        ]);
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok_awal' => 'required|integer|min:0',
        ]);

        $produk->update($validated);

        return redirect()->route('produks.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect()->route('produks.index')->with('success', 'Produk berhasil dihapus.');
    }
}
