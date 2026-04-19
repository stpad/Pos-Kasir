<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function create()
    {
        return view('pembayaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'total' => 'required|numeric|min:0',
            'dibayar' => 'required|numeric|min:0',
            'metode' => 'required|string|in:tunai,debit,transfer',
            'catatan' => 'nullable|string|max:255',
        ]);

        $kembalian = max(0, $validated['dibayar'] - $validated['total']);

        return back()->with([
            'success' => 'Pembayaran berhasil diproses.',
            'payment' => [
                'total' => $validated['total'],
                'dibayar' => $validated['dibayar'],
                'kembalian' => $kembalian,
                'metode' => $validated['metode'],
                'catatan' => $validated['catatan'],
            ],
        ]);
    }
}
