<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $produks = Produk::with('kategori')
            ->when($search, function($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhereHas('kategori', function($q) use ($search) {
                          $q->where('nama', 'like', "%{$search}%");
                      });
            })
            ->paginate(10);

        return view('produks.index', compact('produks', 'search'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('produks.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        Produk::create($request->all());
        return redirect()->route('produks.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);
        return view('produks.show', compact('produk'));
    }

    public function edit(string $id)
    {
        $produk    = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        return view('produks.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update($request->all());
        return redirect()->route('produks.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('produks.index')->with('success', 'Produk berhasil dihapus.');
    }
}