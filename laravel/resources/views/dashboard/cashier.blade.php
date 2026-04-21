<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cashier Dashboard') }}
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

        .dash-wrap * { font-family: 'DM Sans', sans-serif; }

        .hero-cashier {
            background: linear-gradient(135deg, #0f0f0f 0%, #1c1c2e 100%);
            border-radius: 20px;
            padding: 32px;
            position: relative;
            overflow: hidden;
        }
        .hero-cashier::before {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(16,185,129,0.25) 0%, transparent 70%);
            border-radius: 50%;
        }

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
        .stat-card .accent-bar {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            border-radius: 20px 20px 0 0;
        }
        .stat-value {
            font-family: 'DM Mono', monospace;
            font-size: 28px;
            font-weight: 500;
            color: #0f0f0f;
            letter-spacing: -1px;
        }
        .icon-wrap {
            width: 48px; height: 48px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
        }

        .section-card {
            background: #fff;
            border: 1px solid #f1f1f1;
            border-radius: 20px;
            padding: 28px;
        }
        .section-title {
            font-size: 15px; font-weight: 600;
            color: #0f0f0f; letter-spacing: -0.3px;
        }

        .action-card {
            display: flex; align-items: center; gap: 16px;
            padding: 18px 20px;
            border-radius: 16px;
            border: 1.5px solid #f1f1f1;
            text-decoration: none;
            transition: all 0.15s;
        }
        .action-card:hover {
            border-color: #0f0f0f;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
            transform: translateY(-2px);
        }
        .action-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim { animation: fadeUp 0.4s ease both; }
        .anim-1 { animation-delay: 0.05s; }
        .anim-2 { animation-delay: 0.10s; }
        .anim-3 { animation-delay: 0.15s; }
        .anim-4 { animation-delay: 0.20s; }
    </style>

    <div class="dash-wrap py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Hero --}}
            <div class="hero-cashier anim anim-1">
                <div style="position:relative; z-index:10;">
                    <p style="font-size:11px; color:#6b7280; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:6px;">Shift aktif</p>
                    <h1 style="font-size:28px; font-weight:700; color:#fff; letter-spacing:-0.5px;">{{ auth()->user()->name }} 👋</h1>
                    <div style="display:flex; align-items:center; gap:16px; margin-top:12px;">
                        <p style="font-size:13px; color:#6b7280;">{{ now()->translatedFormat('l, d F Y') }}</p>
                        <span style="width:4px; height:4px; border-radius:50%; background:#4b5563;"></span>
                        <p style="font-family:'DM Mono',monospace; font-size:13px; color:#10b981;" id="liveClock"></p>
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-4 anim anim-2">

                <div class="stat-card">
                    <div class="accent-bar" style="background: linear-gradient(90deg, #3b82f6, #6366f1);"></div>
                    <div class="icon-wrap mb-4" style="background:#eff6ff;">💰</div>
                    <p class="stat-value">Rp {{ number_format($penjualanHariIni ?? 0, 0, ',', '.') }}</p>
                    <p style="font-size:11px; color:#9ca3af; margin-top:4px; text-transform:uppercase; letter-spacing:0.05em;">Penjualan Hari Ini</p>
                </div>

                <div class="stat-card">
                    <div class="accent-bar" style="background: linear-gradient(90deg, #10b981, #059669);"></div>
                    <div class="icon-wrap mb-4" style="background:#ecfdf5;">🧾</div>
                    <p class="stat-value">{{ $transaksiHariIni ?? 0 }}</p>
                    <p style="font-size:11px; color:#9ca3af; margin-top:4px; text-transform:uppercase; letter-spacing:0.05em;">Transaksi Hari Ini</p>
                </div>

                <div class="stat-card">
                    <div class="accent-bar" style="background: linear-gradient(90deg, #f59e0b, #f97316);"></div>
                    <div class="icon-wrap mb-4" style="background:#fff7ed;">🛒</div>
                    <p class="stat-value">{{ $itemDiKeranjang }}</p>
                    <p style="font-size:11px; color:#9ca3af; margin-top:4px; text-transform:uppercase; letter-spacing:0.05em;">Item di Keranjang</p>
                </div>

            </div>

            

            {{-- Info placeholder transaksi --}}
            <div class="section-card anim anim-4" style="text-align:center; padding: 48px 28px;">
                <div style="width:64px; height:64px; background:#f9fafb; border-radius:20px; display:flex; align-items:center; justify-content:center; font-size:28px; margin:0 auto 16px;">🧾</div>
                <p style="font-size:15px; font-weight:600; color:#374151;">Riwayat Transaksi Hari Ini</p>
                <p style="font-size:13px; color:#9ca3af; margin-top:6px;">Akan muncul setelah fitur transaksi aktif</p>
            </div>

        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('liveClock').textContent =
                now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
</x-app-layout>