@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Edit Produk</h1>
                <p class="mt-1 text-sm text-slate-600">Perbarui data produk dan stok awalnya.</p>
            </div>
            <a href="{{ route('produks.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200">Kembali ke Produk</a>
        </div>

        @if ($errors->any())
            <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-900">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produks.update', $produk) }}" method="POST" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            @method('PUT')

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="nama" class="block text-sm font-medium text-slate-700">Nama Produk</label>
                    <input id="nama" name="nama" value="{{ old('nama', $produk->nama) }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
                </div>
                <div>
                    <label for="kategori_id" class="block text-sm font-medium text-slate-700">Kategori</label>
                    <select id="kategori_id" name="kategori_id" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100">
                        <option value="">Pilih kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $produk->kategori_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <div>
                    <label for="harga_beli" class="block text-sm font-medium text-slate-700">Harga Beli</label>
                    <input id="harga_beli" name="harga_beli" value="{{ old('harga_beli', $produk->harga_beli) }}" type="number" min="0" step="0.01" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
                </div>
                <div>
                    <label for="harga_jual" class="block text-sm font-medium text-slate-700">Harga Jual</label>
                    <input id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}" type="number" min="0" step="0.01" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
                </div>
                <div>
                    <label for="stok_awal" class="block text-sm font-medium text-slate-700">Stok Awal</label>
                    <input id="stok_awal" name="stok_awal" value="{{ old('stok_awal', $produk->stok_awal) }}" type="number" min="0" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white hover:bg-sky-700">Perbarui Produk</button>
                <a href="{{ route('produks.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
            </div>
        </form>
    </div>
@endsection
