{{-- resources/views/dashboard/admin.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — POS Kasir</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'DM Sans', sans-serif; background: #f5f5f7; }
        body { display: flex; overflow: hidden; }

        /* ── Sidebar ── */
        .sidebar { width: 220px; min-width: 220px; background: #111; height: 100vh; display: flex; flex-direction: column; }
        .sb-logo { padding: 22px 20px 18px; border-bottom: 1px solid #222; }
        .sb-logo-name { font-size: 15px; font-weight: 700; color: #fff; letter-spacing: -.3px; }
        .sb-logo-sub { font-size: 10px; color: #555; margin-top: 2px; }
        .sb-nav { flex: 1; padding: 14px 10px; display: flex; flex-direction: column; gap: 2px; overflow-y: auto; }
        .sb-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 9px;
            color: #666; font-size: 13px; font-weight: 500;
            text-decoration: none; transition: all .15s;
        }
        .sb-item:hover { background: #1c1c1c; color: #ccc; }
        .sb-item.active { background: #1c1c1c; color: #fff; }
        .sb-item .dot { width: 5px; height: 5px; border-radius: 50%; background: #10b981; margin-left: auto; flex-shrink: 0; }
        .sb-icon { width: 18px; text-align: center; font-size: 14px; }
        .sb-section { font-size: 9px; color: #444; text-transform: uppercase; letter-spacing: .1em; padding: 14px 12px 6px; }
        .sb-footer { padding: 14px 10px; border-top: 1px solid #1a1a1a; display: flex; flex-direction: column; gap: 2px; }
        .sb-user { display: flex; align-items: center; gap: 10px; padding: 10px 12px; }
        .avatar { width: 32px; height: 32px; border-radius: 9px; background: linear-gradient(135deg,#6366f1,#8b5cf6); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: #fff; flex-shrink: 0; }
        .u-name { font-size: 12px; font-weight: 600; color: #ddd; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .u-role { font-size: 10px; color: #555; }
        .logout-btn { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: 9px; color: #555; font-size: 13px; font-weight: 500; background: none; border: none; cursor: pointer; width: 100%; transition: all .15s; }
        .logout-btn:hover { background: #1c1c1c; color: #ccc; }

        /* ── Main ── */
        .main { flex: 1; height: 100vh; overflow-y: auto; display: flex; flex-direction: column; }

        /* ── Topbar ── */
        .topbar { background: #fff; border-bottom: 1px solid #ebebeb; padding: 0 24px; height: 52px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 10; }
        .topbar-left h1 { font-size: 14px; font-weight: 600; color: #111; }
        .topbar-left p { font-size: 11px; color: #aaa; margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .clock { font-family: 'DM Mono', monospace; font-size: 12px; color: #aaa; }
        .btn-primary { background: #111; color: #fff; font-size: 12px; font-weight: 600; padding: 7px 14px; border-radius: 8px; text-decoration: none; white-space: nowrap; }

        /* ── Content ── */
        .content { padding: 18px 24px; flex: 1; }

        /* ── Stat Cards ── */
        .stats { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 16px; }
        .s-card { background: #fff; border: 1px solid #ebebeb; border-radius: 14px; padding: 16px 18px; position: relative; overflow: hidden; }
        .s-accent { position: absolute; top: 0; left: 0; right: 0; height: 3px; }
        .s-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
        .s-label { font-size: 10px; color: #aaa; text-transform: uppercase; letter-spacing: .05em; }
        .s-icon { font-size: 16px; }
        .s-val { font-family: 'DM Mono', monospace; font-size: 20px; font-weight: 500; color: #111; letter-spacing: -.5px; }
        .s-sub { font-size: 10px; color: #bbb; margin-top: 3px; }

        /* ── Grid ── */
        .grid2 { display: grid; grid-template-columns: 1fr 320px; gap: 14px; }
        .col { display: flex; flex-direction: column; gap: 14px; }

        /* ── Card ── */
        .card { background: #fff; border: 1px solid #ebebeb; border-radius: 14px; padding: 18px; }
        .c-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .c-title { font-size: 13px; font-weight: 600; color: #111; }
        .c-link { font-size: 11px; color: #6366f1; text-decoration: none; }
        .c-link:hover { text-decoration: underline; }
        .period-btns { display: flex; gap: 4px; }
        .pb { padding: 4px 9px; font-size: 11px; font-weight: 500; border-radius: 6px; border: none; cursor: pointer; transition: all .1s; }
        .pb.on { background: #111; color: #fff; }
        .pb:not(.on) { background: #f4f4f5; color: #777; }

        /* ── Table ── */
        .t { width: 100%; border-collapse: collapse; }
        .t th { text-align: left; font-size: 10px; color: #aaa; text-transform: uppercase; letter-spacing: .05em; padding: 0 0 8px; border-bottom: 1px solid #f4f4f5; }
        .t td { padding: 9px 0; border-bottom: 1px solid #fafafa; font-size: 12px; color: #444; vertical-align: middle; }
        .t tr:last-child td { border-bottom: none; }
        .badge { display: inline-flex; padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 600; }
        .b-red { background: #fef2f2; color: #dc2626; }
        .b-yel { background: #fefce8; color: #ca8a04; }

        /* ── Rank rows ── */
        .rank { display: flex; align-items: center; gap: 10px; padding: 9px 0; border-bottom: 1px solid #fafafa; }
        .rank:last-child { border-bottom: none; }
        .r-n { font-size: 10px; font-weight: 700; color: #bbb; width: 14px; text-align: center; flex-shrink: 0; }
        .r-name { flex: 1; font-size: 12px; font-weight: 500; color: #111; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .r-val { font-family: 'DM Mono', monospace; font-size: 11px; color: #059669; white-space: nowrap; }

        /* ── Quick action ── */
        .qa { display: flex; align-items: center; gap: 10px; padding: 9px 12px; background: #fafafa; border-radius: 9px; text-decoration: none; transition: background .15s; }
        .qa:hover { background: #f3f4f6; }
        .qa-icon { font-size: 14px; width: 18px; text-align: center; }
        .qa-label { font-size: 12px; font-weight: 500; color: #374151; flex: 1; }
        .qa-arr { color: #d1d5db; font-size: 12px; }

        ::-webkit-scrollbar { width: 3px; }
        ::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 3px; }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<div class="sidebar">
    <div class="sb-logo">
        <div class="sb-logo-name">POS Kasir</div>
        <div class="sb-logo-sub">Management System</div>
    </div>

    <nav class="sb-nav">
        <div class="sb-section">Menu</div>
        <a href="{{ route('dashboard') }}" class="sb-item active">
            <span class="sb-icon">📊</span> Dashboard <span class="dot"></span>
        </a>
        <a href="{{ route('kasirs.index') }}" class="sb-item">
            <span class="sb-icon">👥</span> Data Kasir
        </a>
        <a href="{{ route('kategoris.index') }}" class="sb-item">
            <span class="sb-icon">📁</span> Kategori
        </a>
        <a href="{{ route('produks.index') }}" class="sb-item">
            <span class="sb-icon">📦</span> Produk
        </a>
        <div class="sb-section">Akun</div>
        <a href="{{ route('profile.edit') }}" class="sb-item">
            <span class="sb-icon">👤</span> Profil
        </a>
    </nav>

    <div class="sb-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <span class="sb-icon">🚪</span> Keluar
            </button>
        </form>
        <div class="sb-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
            <div>
                <div class="u-name">{{ auth()->user()->name }}</div>
                <div class="u-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>
    </div>
</div>

{{-- MAIN --}}
<div class="main">
    <div class="topbar">
        <div class="topbar-left">
            <h1>Dashboard Overview</h1>
            <p>{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="topbar-right">
            <span class="clock" id="clock"></span>
            <a href="{{ route('produks.create') }}" class="btn-primary">+ Tambah Produk</a>
        </div>
    </div>

    <div class="content">

        {{-- Stats --}}
        <div class="stats">
            <div class="s-card">
                <div class="s-accent" style="background:linear-gradient(90deg,#3b82f6,#6366f1);"></div>
                <div class="s-top"><span class="s-label">Penjualan Hari Ini</span><span class="s-icon">💰</span></div>
                <div class="s-val">Rp {{ number_format($totalPenjualanHariIni ?? 0, 0, ',', '.') }}</div>
                <div class="s-sub">{{ $totalTransaksiHariIni ?? 0 }} transaksi</div>
            </div>
            <div class="s-card">
                <div class="s-accent" style="background:linear-gradient(90deg,#10b981,#059669);"></div>
                <div class="s-top"><span class="s-label">Total Transaksi</span><span class="s-icon">🧾</span></div>
                <div class="s-val">{{ $totalTransaksiHariIni ?? 0 }}</div>
                <div class="s-sub">Transaksi hari ini</div>
            </div>
            <div class="s-card">
                <div class="s-accent" style="background:linear-gradient(90deg,#8b5cf6,#7c3aed);"></div>
                <div class="s-top"><span class="s-label">Total Produk</span><span class="s-icon">📦</span></div>
                <div class="s-val">{{ $totalProduk }}</div>
                <div class="s-sub">Produk terdaftar</div>
            </div>
            <div class="s-card">
                <div class="s-accent" style="background:linear-gradient(90deg,#f59e0b,#ef4444);"></div>
                <div class="s-top"><span class="s-label">Stok Hampir Habis</span><span class="s-icon">⚠️</span></div>
                <div class="s-val" style="{{ $stokHampirHabis > 0 ? 'color:#dc2626' : '' }}">{{ $stokHampirHabis }}</div>
                <div class="s-sub">Produk stok ≤ 5</div>
            </div>
        </div>

        {{-- Bottom grid --}}
        <div class="grid2">
            <div class="col">

                {{-- Chart --}}
                <div class="card">
                    <div class="c-head">
                        <span class="c-title">Grafik Penjualan</span>
                        <div class="period-btns">
                            <button class="pb on" onclick="loadChart(7,this)">7H</button>
                            <button class="pb" onclick="loadChart(30,this)">30H</button>
                            <button class="pb" onclick="loadChart(90,this)">90H</button>
                        </div>
                    </div>
                    <div style="height:150px; position:relative;">
                        <canvas id="salesChart"></canvas>
                        <div id="chartEmpty" style="display:none; position:absolute; inset:0; align-items:center; justify-content:center; flex-direction:column; color:#bbb; gap:6px;">
                            <span style="font-size:28px;">📉</span>
                            <span style="font-size:12px;">Belum ada data penjualan</span>
                        </div>
                    </div>
                </div>

                {{-- Stok hampir habis --}}
                <div class="card">
                    <div class="c-head">
                        <span class="c-title">⚠️ Stok Hampir Habis</span>
                        <a href="{{ route('produks.index') }}" class="c-link">Lihat semua →</a>
                    </div>
                    @if($produkStokRendah->isNotEmpty())
                    <table class="t">
                        <thead><tr>
                            <th>Produk</th><th>Kategori</th><th>Stok</th><th style="text-align:right;">Aksi</th>
                        </tr></thead>
                        <tbody>
                            @foreach($produkStokRendah as $p)
                            <tr>
                                <td style="font-weight:500; color:#111;">{{ $p->nama }}</td>
                                <td style="color:#aaa;">{{ $p->kategori->nama ?? '-' }}</td>
                                <td>
                                    @if($p->stok <= 3)
                                        <span class="badge b-red">🚨 {{ $p->stok }}</span>
                                    @else
                                        <span class="badge b-yel">⚠️ {{ $p->stok }}</span>
                                    @endif
                                </td>
                                <td style="text-align:right;"><a href="{{ route('produks.edit', $p) }}" class="c-link">Edit →</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div style="text-align:center; padding:20px; color:#bbb;">
                        <div style="font-size:24px; margin-bottom:6px;">✅</div>
                        <div style="font-size:12px;">Semua stok aman</div>
                    </div>
                    @endif
                </div>

            </div>

            <div class="col">

                {{-- Top produk --}}
                <div class="card">
                    <div class="c-head"><span class="c-title">🏆 Top Produk Terlaris</span></div>
                    @if(isset($produkTerlaris) && $produkTerlaris->isNotEmpty())
                        @foreach($produkTerlaris as $i => $item)
                        <div class="rank">
                            <span class="r-n">@if($i==0)🥇@elseif($i==1)🥈@elseif($i==2)🥉@else{{ $i+1 }}@endif</span>
                            <span class="r-name">{{ $item->nama }}</span>
                            <span class="r-val">{{ number_format($item->total_penjualan,0,',','.') }}</span>
                        </div>
                        @endforeach
                    @else
                    <div style="text-align:center; padding:28px 0; color:#bbb;">
                        <div style="font-size:32px; margin-bottom:8px;">🏆</div>
                        <div style="font-size:12px;">Belum ada data</div>
                        <div style="font-size:11px; margin-top:4px; color:#d1d5db;">Muncul setelah ada transaksi</div>
                    </div>
                    @endif
                </div>

                {{-- Quick actions --}}
                <div class="card">
                    <div class="c-head"><span class="c-title">⚡ Aksi Cepat</span></div>
                    <div style="display:flex; flex-direction:column; gap:6px;">
                        <a href="{{ route('produks.create') }}" class="qa">
                            <span class="qa-icon">➕</span><span class="qa-label">Tambah Produk</span><span class="qa-arr">→</span>
                        </a>
                        <a href="{{ route('kategoris.index') }}" class="qa">
                            <span class="qa-icon">📁</span><span class="qa-label">Kelola Kategori</span><span class="qa-arr">→</span>
                        </a>
                        <a href="{{ route('kasirs.index') }}" class="qa">
                            <span class="qa-icon">👥</span><span class="qa-label">Data Kasir</span><span class="qa-arr">→</span>
                        </a>
                        <a href="{{ route('produks.index') }}" class="qa">
                            <span class="qa-icon">📦</span><span class="qa-label">Lihat Produk</span><span class="qa-arr">→</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function tick() { document.getElementById('clock').textContent = new Date().toLocaleTimeString('id-ID'); }
    tick(); setInterval(tick, 1000);

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
                data: { labels: data.labels, datasets: [{ data: data.values, backgroundColor: 'rgba(99,102,241,.12)', borderColor: '#6366f1', borderWidth: 1.5, borderRadius: 5, hoverBackgroundColor: 'rgba(99,102,241,.25)' }] },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: { backgroundColor: '#111', padding: 10, callbacks: { label: c => 'Rp ' + c.raw.toLocaleString('id-ID') } } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f4f4f5' }, ticks: { color: '#bbb', font: { size: 10 }, callback: v => 'Rp ' + v.toLocaleString('id-ID') } },
                        x: { grid: { display: false }, ticks: { color: '#bbb', font: { size: 10 } } }
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
</body>
</html>