@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Produk</h1>
                <p class="mt-1 text-sm text-slate-600">Kelola stok dan temukan produk yang hampir habis.</p>
            </div>
            <a href="{{ route('produks.create') }}" class="inline-flex items-center rounded-md bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700">Tambah Produk</a>
        </div>

        @if(session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('success') }}</div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Jumlah produk</div>
                <div class="mt-3 text-3xl font-semibold text-slate-900">{{ $produks->count() }}</div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Stok hampir habis (≤ {{ $lowStockThreshold }})</div>
                <div class="mt-3 text-3xl font-semibold text-amber-700">{{ $lowStockProduks->count() }}</div>
            </div>
        </div>

        @if($lowStockProduks->isNotEmpty())
            <section class="rounded-3xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-amber-900">Produk dengan stok hampir habis</h2>
                        <p class="mt-1 text-sm text-amber-700">Segera isi ulang produk berikut agar tidak kehabisan stok.</p>
                    </div>
                </div>

                <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($lowStockProduks as $produk)
                        <div class="rounded-3xl bg-white p-4 shadow-sm">
                            <div class="text-sm font-semibold text-slate-900">{{ $produk->nama }}</div>
                            <div class="mt-1 text-sm text-slate-600">Kategori: {{ $produk->kategori?->nama ?? '-' }}</div>
                            <div class="mt-3 flex items-center justify-between gap-3 text-sm text-slate-500">
                                <span>Stok awal</span>
                                <span class="font-semibold text-amber-700">{{ $produk->stok_awal }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50 text-slate-700">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama</th>
                        <th class="px-4 py-3 font-medium">Kategori</th>
                        <th class="px-4 py-3 font-medium">Harga Beli</th>
                        <th class="px-4 py-3 font-medium">Harga Jual</th>
                        <th class="px-4 py-3 font-medium">Stok Awal</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($produks as $produk)
                        <tr>
                            <td class="px-4 py-4">{{ $produk->nama }}</td>
                            <td class="px-4 py-4">{{ $produk->kategori?->nama ?? 'Tidak ada' }}</td>
                            <td class="px-4 py-4">Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                            <td class="px-4 py-4">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                            <td class="px-4 py-4">{{ $produk->stok_awal }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $produk->isLowStock() ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                    {{ $produk->isLowStock() ? 'Hampir Habis' : 'Aman' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('produks.edit', $produk) }}" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-200">Edit</a>
                                    <form action="{{ route('produks.destroy', $produk) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus produk ini?')" class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700 hover:bg-rose-200">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada produk. Tambahkan produk baru untuk mulai mengelola stok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
