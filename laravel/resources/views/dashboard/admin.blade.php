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
        .stat-sub { font-size: 11px; color: #bbb; margin-top: 4px; }
        .chart-card {
            background: #fff;
            border: 1px solid #f1f1f1;
            border-radius: 20px;
            padding: 24px;
            margin-top: 16px;
        }
        .chart-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 16px;
        }
        .chart-title { font-size: 14px; font-weight: 600; color: #111; }
        .period-btns { display: flex; gap: 4px; }
        .pb {
            padding: 4px 10px; font-size: 11px; font-weight: 500;
            border-radius: 6px; border: none; cursor: pointer; transition: all .1s;
        }
        .pb.on { background: #111; color: #fff; }
        .pb:not(.on) { background: #f4f4f5; color: #777; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="dash-wrap py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Stat Cards --}}
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

            {{-- Grafik Penjualan --}}
            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">📈 Grafik Penjualan</span>
                    <div class="period-btns">
                        <button class="pb on" onclick="loadChart(7,this)">7H</button>
                        <button class="pb" onclick="loadChart(30,this)">30H</button>
                        <button class="pb" onclick="loadChart(90,this)">90H</button>
                    </div>
                </div>
                <div style="position:relative; height:220px;">
                    <canvas id="salesChart"></canvas>
                    <div id="chartEmpty" style="display:none; position:absolute; inset:0; display:flex; align-items:center; justify-content:center; flex-direction:column; color:#bbb; gap:6px;">
                        <span style="font-size:32px;">📉</span>
                        <span style="font-size:13px;">Belum ada data penjualan</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        let chart;
        async function loadChart(days, btn) {
            document.querySelectorAll('.pb').forEach(b => b.classList.remove('on'));
            if (btn) btn.classList.add('on');
            try {
                const res = await fetch(`/api/sales-chart?days=${days}`);
                const data = await res.json();
                const empty = !data.labels?.length || data.values?.every(v => v === 0);
                document.getElementById('chartEmpty').style.display = empty ? 'flex' : 'none';
                document.getElementById('salesChart').style.display = empty ? 'none' : 'block';
                if (empty) return;
                if (chart) chart.destroy();
                chart = new Chart(document.getElementById('salesChart').getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.values,
                            backgroundColor: 'rgba(99,102,241,.12)',
                            borderColor: '#6366f1',
                            borderWidth: 1.5,
                            borderRadius: 6,
                            hoverBackgroundColor: 'rgba(99,102,241,.25)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#111',
                                padding: 10,
                                callbacks: { label: c => 'Rp ' + c.raw.toLocaleString('id-ID') }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: '#f4f4f5' },
                                ticks: { color: '#bbb', font: { size: 11 }, callback: v => 'Rp ' + v.toLocaleString('id-ID') }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { color: '#bbb', font: { size: 11 } }
                            }
                        }
                    }
                });
            } catch(e) {
                document.getElementById('chartEmpty').style.display = 'flex';
                document.getElementById('salesChart').style.display = 'none';
            }
        }
        loadChart(7, document.querySelector('.pb'));
    </script>
</x-app-layout>