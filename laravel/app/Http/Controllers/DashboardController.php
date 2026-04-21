<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Cart;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Data umum untuk semua role
        $totalProduk = Produk::count();
        $totalKategori = Kategori::count();
        
        // Data stok untuk admin
        $stokHampirHabis = Produk::where('stok', '<=', 5)->count();
        $produkStokRendah = Produk::with('kategori')
            ->where('stok', '<=', 5)
            ->orderBy('stok', 'asc')
            ->get();
        
        // Data penjualan (jika tabel transaksi sudah ada)
        $totalPenjualanHariIni = 0;
        $totalTransaksiHariIni = 0;
        $totalPenjualanBulanIni = 0;
        $totalTransaksiBulanIni = 0;
        $produkTerlaris = collect();
        $recentTransactions = collect();
        
        // Cek apakah model Transaksi ada
        if (class_exists('App\Models\Transaksi')) {
            // Data hari ini
            $totalPenjualanHariIni = Transaksi::whereDate('created_at', today())
                ->where('status', 'selesai')
                ->sum('total_harga');
                
            $totalTransaksiHariIni = Transaksi::whereDate('created_at', today())
                ->where('status', 'selesai')
                ->count();
            
            // Data bulan ini
            $totalPenjualanBulanIni = Transaksi::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('status', 'selesai')
                ->sum('total_harga');
                
            $totalTransaksiBulanIni = Transaksi::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('status', 'selesai')
                ->count();
            
            // Produk terlaris (untuk admin)
            $produkTerlaris = DetailTransaksi::select(
                    'produk_id',
                    DB::raw('SUM(quantity) as total_terjual'),
                    DB::raw('SUM(subtotal) as total_penjualan')
                )
                ->with('produk.kategori')
                ->groupBy('produk_id')
                ->orderBy('total_terjual', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    if ($item->produk) {
                        $item->nama = $item->produk->nama;
                        $item->kategori = $item->produk->kategori;
                    }
                    return $item;
                });
            
            // Transaksi terbaru (untuk cashier)
            if ($user->role !== 'admin') {
                $recentTransactions = Transaksi::where('cashier_id', $user->id)
                    ->where('status', 'selesai')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
            }
        }

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return view('dashboard.admin', compact(
                'totalProduk',
                'totalKategori',
                'stokHampirHabis',
                'produkStokRendah',
                'totalPenjualanHariIni',
                'totalTransaksiHariIni',
                'totalPenjualanBulanIni',
                'totalTransaksiBulanIni',
                'produkTerlaris'
            ));
        }

        // Untuk cashier/user biasa
        $itemDiKeranjang = Cart::where('user_id', $user->id)->sum('quantity');
        
        return view('dashboard.cashier', compact(
            'totalProduk',
            'itemDiKeranjang',
            'totalPenjualanHariIni',
            'totalTransaksiHariIni',
            'totalPenjualanBulanIni',
            'totalTransaksiBulanIni',
            'recentTransactions'
        ));
    }
    
    /**
     * API untuk chart penjualan
     */
    public function salesChart(Request $request)
    {
        try {
            $days = $request->get('days', 7);
            
            // Validasi days
            if (!in_array($days, [7, 30, 90])) {
                $days = 7;
            }
            
            $sales = Transaksi::where('status', 'selesai')
                ->where('created_at', '>=', now()->subDays($days))
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(total_harga) as total')
                )
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get()
                ->keyBy('date');
            
            $labels = [];
            $values = [];
            
            // Generate data untuk setiap hari
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $labels[] = now()->subDays($i)->format('d/m');
                $sale = $sales->get($date);
                $values[] = $sale ? (float) $sale->total : 0;
            }
            
            return response()->json([
                'success' => true,
                'labels' => $labels,
                'values' => $values
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'labels' => [],
                'values' => [],
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * API untuk statistik cepat (optional)
     */
    public function quickStats()
    {
        try {
            $user = auth()->user();
            
            $stats = [
                'total_produk' => Produk::count(),
                'total_kategori' => Kategori::count(),
                'stok_menipis' => Produk::where('stok', '<=', 5)->count(),
            ];
            
            if (class_exists('App\Models\Transaksi')) {
                $stats['penjualan_hari_ini'] = Transaksi::whereDate('created_at', today())
                    ->where('status', 'selesai')
                    ->sum('total_harga');
                    
                $stats['transaksi_hari_ini'] = Transaksi::whereDate('created_at', today())
                    ->where('status', 'selesai')
                    ->count();
            }
            
            if ($user->role !== 'admin') {
                $stats['item_di_keranjang'] = Cart::where('user_id', $user->id)->sum('quantity');
            }
            
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}