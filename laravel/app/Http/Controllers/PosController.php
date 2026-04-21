<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $produks   = Produk::with('kategori')->get();
        $kategoris = Kategori::all();
        return view('kasirs.kasir', compact('produks', 'kategoris'));
    }
}