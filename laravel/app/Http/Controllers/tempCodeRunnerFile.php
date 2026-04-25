<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        $penjualanHariIni = Transaksi::whereDate(
            'created_at',
            Carbon::today()
        )->sum('total_harga');

        $totalTransaksi = Transaksi::count();

        $grafikPenjualan = Transaksi::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total_harga) as total')
            )
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('dashboard', compact(
            'jumlahProduk',
            'jumlahKategori',
            'produkStokRendah',
            'penjualanHariIni',
            'totalTransaksi',
            'grafikPenjualan'
        ));

        $kategoriChart = Kategori::withCount('produks')->get();

$produkStokRendah = Produk::where('stok', '<', 10)
    ->orderBy('stok')
    ->get();

return view('dashboard', compact(
    'jumlahProduk',
    'jumlahKategori',
    'penjualanHariIni',
    'totalTransaksi',
    'grafikPenjualan',
    'kategoriChart',
    'produkStokRendah'
));
    }
}