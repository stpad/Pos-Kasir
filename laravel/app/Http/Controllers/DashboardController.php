<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'cashier') {
            return view('dashboard-cashier');
        }
        
        $jumlahProduk = Produk::count();
        $jumlahKategori = Kategori::count();
        $produkStokRendah = Produk::where('stok', '<', 10)->get();
        
        return view('dashboard', compact('jumlahProduk', 'jumlahKategori', 'produkStokRendah'));
    }
}