@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Detail Kategori</h1>
                <p class="mt-1 text-sm text-slate-600">{{ $kategori->nama }} — lihat produk dalam kategori ini dan status stoknya.</p>
            </div>
            <a href="{{ route('kategoris.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200">Kembali ke Kategori</a>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">{{ $kategori->nama }}</h2>
                    <p class="mt-2 text-sm text-slate-600">{{ $kategori->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 px-4 py-3 text-sm text-slate-700">
                    <div class="font-semibold text-slate-900">Total Produk</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $kategori->produks->count() }}</div>
                </div>
            </div>
            <div class="mt-4 text-sm text-slate-500">Dibuat pada: {{ $kategori->created_at->format('d M Y H:i') }}</div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Stok hampir habis</div>
                <div class="mt-3 text-3xl font-semibold text-amber-700">{{ $lowStockProducts->count() }}</div>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50 text-slate-700">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama Produk</th>
                        <th class="px-4 py-3 font-medium">Harga Jual</th>
                        <th class="px-4 py-3 font-medium">Stok Awal</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($kategori->produks as $produk)
                        <tr>
                            <td class="px-4 py-4">{{ $produk->nama }}</td>
                            <td class="px-4 py-4">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                            <td class="px-4 py-4">{{ $produk->stok_awal }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $produk->stok_awal <= 5 ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                    {{ $produk->stok_awal <= 5 ? 'Hampir Habis' : 'Aman' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada produk di kategori ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
