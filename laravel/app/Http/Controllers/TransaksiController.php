<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'produk_id' => 'required|array|min:1',
            'produk_id.*' => 'required|exists:produks,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'harga_satuan' => 'required|array|min:1',
            'harga_satuan.*' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
        ]);

        DB::transaction(function () use ($validated) {
            $total = 0;
            foreach ($validated['produk_id'] as $index => $produkId) {
                $subtotal = $validated['jumlah'][$index] * $validated['harga_satuan'][$index];
                $total += $subtotal;
            }

            $transaksi = Transaksi::create([
                'total' => $total,
                'tanggal' => $validated['tanggal'],
            ]);

            foreach ($validated['produk_id'] as $index => $produkId) {
                $subtotal = $validated['jumlah'][$index] * $validated['harga_satuan'][$index];
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $produkId,
                    'jumlah' => $validated['jumlah'][$index],
                    'harga_satuan' => $validated['harga_satuan'][$index],
                    'subtotal' => $subtotal,
                ]);
            }
        });

        return redirect()->route('transaksi.create')->with('success', 'Transaksi berhasil disimpan.');
    }
}
