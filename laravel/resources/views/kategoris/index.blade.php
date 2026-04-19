@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Kategori</h1>
                <p class="mt-1 text-sm text-slate-600">Kelola kategori dan lihat ringkasan produk yang hampir habis stoknya.</p>
            </div>
            <a href="{{ route('kategoris.create') }}" class="inline-flex items-center rounded-md bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700">Tambah Kategori</a>
        </div>

        @if(session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('success') }}</div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Jumlah Kategori</div>
                <div class="mt-3 text-3xl font-semibold text-slate-900">{{ $kategoris->count() }}</div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Produk stok hampir habis</div>
                <div class="mt-3 text-3xl font-semibold text-amber-700">{{ $lowStockCount }}</div>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50 text-slate-700">
                    <tr>
                        <th class="px-4 py-3 font-medium">ID</th>
                        <th class="px-4 py-3 font-medium">Nama</th>
                        <th class="px-4 py-3 font-medium">Deskripsi</th>
                        <th class="px-4 py-3 font-medium">Jumlah Produk</th>
                        <th class="px-4 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($kategoris as $kategori)
                        <tr>
                            <td class="px-4 py-4">{{ $kategori->id }}</td>
                            <td class="px-4 py-4">{{ $kategori->nama }}</td>
                            <td class="px-4 py-4">{{ $kategori->deskripsi }}</td>
                            <td class="px-4 py-4">{{ $kategori->produks_count }}</td>
                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('kategoris.show', $kategori) }}" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-200">Lihat</a>
                                    <a href="{{ route('kategoris.edit', $kategori) }}" class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800 hover:bg-amber-200">Edit</a>
                                    <form action="{{ route('kategoris.destroy', $kategori) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus kategori ini?')" class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700 hover:bg-rose-200">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada kategori. Tambahkan kategori untuk mulai mengelola produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
