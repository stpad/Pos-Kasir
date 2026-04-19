@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col gap-4 max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-lg shadow">
            <div>
                <h1 class="text-3xl font-bold">Daftar Produk</h1>
                <p class="text-gray-500 mt-1">Kelola produk, harga, dan stok.</p>
            </div>
            <a href="{{ route('produks.create') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Tambah Produk</a>
        </div>

        @if(session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Harga Beli</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Harga Jual</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Stok</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Stok Awal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($produks as $produk)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $produk->id }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $produk->nama }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $produk->stok }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $produk->stok_awal }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $produk->kategori->nama ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('produks.show', $produk->id) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                    <a href="{{ route('produks.edit', $produk->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                    <form action="{{ route('produks.destroy', $produk->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-sm text-gray-500">Belum ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection