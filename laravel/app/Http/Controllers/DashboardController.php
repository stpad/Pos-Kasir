<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahProduk = Produk::count();
        $jumlahKategori = Kategori::count();
        
        return view('dashboard', compact('jumlahProduk', 'jumlahKategori'));
    }
}