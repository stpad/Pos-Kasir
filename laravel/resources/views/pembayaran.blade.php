<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung Kembalian - Pos Kasir</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
        </style>
    @endif
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <header class="mb-8 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-slate-900">Hitung Kembalian</h1>
                    <p class="mt-2 text-sm text-slate-600">Masukkan total dan jumlah yang dibayar untuk melihat kembalian secara instan.</p>
                </div>
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200">Kembali ke Beranda</a>
            </div>
        </header>

        <section class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <form id="paymentForm" class="space-y-6">
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="total" class="block text-sm font-medium text-slate-700">Total Tagihan</label>
                            <input id="total" name="total" type="number" min="0" step="0.01" value="0" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
                        </div>
                        <div>
                            <label for="dibayar" class="block text-sm font-medium text-slate-700">Jumlah Dibayarkan</label>
                            <input id="dibayar" name="dibayar" type="number" min="0" step="0.01" value="0" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="rounded-2xl bg-white p-4 text-sm shadow-sm">
                                <span class="block text-slate-500">Total</span>
                                <span id="displayTotal" class="mt-2 block text-lg font-semibold text-slate-900">Rp 0</span>
                            </div>
                            <div class="rounded-2xl bg-white p-4 text-sm shadow-sm">
                                <span class="block text-slate-500">Dibayar</span>
                                <span id="displayPaid" class="mt-2 block text-lg font-semibold text-slate-900">Rp 0</span>
                            </div>
                            <div class="rounded-2xl bg-white p-4 text-sm shadow-sm">
                                <span class="block text-slate-500">Kembalian</span>
                                <span id="displayChange" class="mt-2 block text-lg font-semibold text-emerald-700">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button type="button" id="calculateButton" class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white hover:bg-sky-700">Hitung Kembalian</button>
                        <button type="button" id="resetButton" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</button>
                    </div>
                </form>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Petunjuk</h2>
                <p class="mt-2 text-sm text-slate-600">Isi total tagihan dan jumlah yang dibayar lalu tekan tombol hitung untuk melihat kembalian. Kembalian akan tampil secara langsung di kartu ringkasan.</p>
            </div>
        </section>
    </div>

    <script>
        const totalInput = document.getElementById('total');
        const paidInput = document.getElementById('dibayar');
        const displayTotal = document.getElementById('displayTotal');
        const displayPaid = document.getElementById('displayPaid');
        const displayChange = document.getElementById('displayChange');
        const calculateButton = document.getElementById('calculateButton');
        const resetButton = document.getElementById('resetButton');

        const formatRupiah = (value) => {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value);
        };

        const updateSummary = () => {
            const total = Number(totalInput.value) || 0;
            const paid = Number(paidInput.value) || 0;
            const change = Math.max(0, paid - total);

            displayTotal.textContent = formatRupiah(total);
            displayPaid.textContent = formatRupiah(paid);
            displayChange.textContent = formatRupiah(change);
        };

        calculateButton.addEventListener('click', updateSummary);
        resetButton.addEventListener('click', () => {
            totalInput.value = 0;
            paidInput.value = 0;
            updateSummary();
        });

        totalInput.addEventListener('input', updateSummary);
        paidInput.addEventListener('input', updateSummary);

        updateSummary();
    </script>
</body>
</html>
