@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-3xl font-bold mb-4">Detail Produk</h1>
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                <p class="text-sm text-gray-500">Nama Produk</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $produk->nama }}</p>
            </div>
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                <p class="text-sm text-gray-500">Kategori</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $produk->kategori->nama ?? 'N/A' }}</p>
            </div>
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                <p class="text-sm text-gray-500">Harga Beli</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                <p class="text-sm text-gray-500">Harga Jual</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                <p class="text-sm text-gray-500">Stok</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $produk->stok }}</p>
            </div>
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                <p class="text-sm text-gray-500">Stok Awal</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $produk->stok_awal }}</p>
            </div>
            <div class="sm:col-span-2 rounded-lg border border-gray-200 bg-gray-50 p-4">
                <p class="text-sm text-gray-500">Deskripsi</p>
                <p class="mt-2 text-gray-900">{{ $produk->deskripsi ?: 'Tidak ada deskripsi' }}</p>
            </div>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('produks.index') }}" class="inline-flex items-center justify-center rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">Kembali</a>
            <a href="{{ route('produks.edit', $produk->id) }}" class="inline-flex items-center justify-center rounded-md bg-yellow-500 px-4 py-2 text-sm font-semibold text-white hover:bg-yellow-600">Edit</a>
        </div>
    </div>
</div>
@endsection