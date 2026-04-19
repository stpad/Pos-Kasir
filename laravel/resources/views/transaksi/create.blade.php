@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Simpan Transaksi</h1>
                <p class="mt-1 text-sm text-slate-600">Catat transaksi penjualan produk.</p>
            </div>
            <a href="{{ route('produks.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200">Kembali ke Produk</a>
        </div>

        @if(session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-900">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach>
                </ul>
            </div>
        @endif

        <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="produk_id" class="block text-sm font-medium text-slate-700">Produk</label>
                    <select id="produk_id" name="produk_id" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100">
                        <option value="">Pilih produk</option>
                        @foreach ($produks as $produk)
                            <option value="{{ $produk->id }}" {{ old('produk_id') == $produk->id ? 'selected' : '' }}>{{ $produk->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="jumlah" class="block text-sm font-medium text-slate-700">Jumlah</label>
                    <input id="jumlah" name="jumlah" type="number" min="1" value="{{ old('jumlah') }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="harga_satuan" class="block text-sm font-medium text-slate-700">Harga Satuan</label>
                    <input id="harga_satuan" name="harga_satuan" type="number" min="0" step="0.01" value="{{ old('harga_satuan') }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
                </div>
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-slate-700">Tanggal</label>
                    <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal', date('Y-m-d')) }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex items-center justify-between text-sm text-slate-600">
                    <span>Total</span>
                    <span class="font-semibold text-slate-900" id="displayTotal">Rp 0</span>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white hover:bg-sky-700">Simpan Transaksi</button>
                <a href="{{ route('transaksi.create') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function formatRupiah(value) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value);
            }

            function updateTotal() {
                const jumlah = Number(document.getElementById('jumlah').value) || 0;
                const hargaSatuan = Number(document.getElementById('harga_satuan').value) || 0;
                const total = jumlah * hargaSatuan;

                document.getElementById('displayTotal').textContent = formatRupiah(total);
            }

            document.getElementById('jumlah').addEventListener('input', updateTotal);
            document.getElementById('harga_satuan').addEventListener('input', updateTotal);

            updateTotal();
        </script>
    @endpush
@endsection