{{-- resources/views/dashboard/admin.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');
        .dash-wrap * { font-family: 'DM Sans', sans-serif; }
        .stat-card {
            background: #fff;
            border: 1px solid #f1f1f1;
            border-radius: 20px;
            padding: 24px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }
        .accent-bar {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            border-radius: 20px 20px 0 0;
        }
        .stat-label {
            font-size: 10px; color: #aaa;
            text-transform: uppercase; letter-spacing: .05em;
            margin-bottom: 10px;
        }
        .stat-value {
            font-family: 'DM Mono', monospace;
            font-size: 28px; font-weight: 500;
            color: #111; letter-spacing: -1px;
        }
        .stat-sub {
            font-size: 11px; color: #bbb; margin-top: 4px;
        }
    </style>

    <div class="dash-wrap py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:16px;">

                <div class="stat-card">
                    <div class="accent-bar" style="background:linear-gradient(90deg,#3b82f6,#6366f1);"></div>
                    <div class="stat-label">Penjualan Hari Ini</div>
                    <div class="stat-value">Rp {{ number_format($totalPenjualanHariIni ?? 0, 0, ',', '.') }}</div>
                    <div class="stat-sub">{{ $totalTransaksiHariIni ?? 0 }} transaksi</div>
                </div>

                <div class="stat-card">
                    <div class="accent-bar" style="background:linear-gradient(90deg,#10b981,#059669);"></div>
                    <div class="stat-label">Total Transaksi</div>
                    <div class="stat-value">{{ $totalTransaksiHariIni ?? 0 }}</div>
                    <div class="stat-sub">Transaksi hari ini</div>
                </div>

                <div class="stat-card">
                    <div class="accent-bar" style="background:linear-gradient(90deg,#8b5cf6,#7c3aed);"></div>
                    <div class="stat-label">Total Produk</div>
                    <div class="stat-value">{{ $totalProduk }}</div>
                    <div class="stat-sub">Produk terdaftar</div>
                </div>

                <div class="stat-card">
                    <div class="accent-bar" style="background:linear-gradient(90deg,#f59e0b,#ef4444);"></div>
                    <div class="stat-label">Stok Hampir Habis</div>
                    <div class="stat-value" style="{{ ($stokHampirHabis ?? 0) > 0 ? 'color:#dc2626' : '' }}">{{ $stokHampirHabis ?? 0 }}</div>
                    <div class="stat-sub">Produk stok ≤ 5</div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>