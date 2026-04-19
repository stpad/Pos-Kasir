<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function create()
    {
        $produks = Produk::all();
        return view('transaksi.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
        ]);

        $validated['total'] = $validated['jumlah'] * $validated['harga_satuan'];

        Transaksi::create($validated);

        return redirect()->route('transaksi.create')->with('success', 'Transaksi berhasil disimpan.');
    }
}
