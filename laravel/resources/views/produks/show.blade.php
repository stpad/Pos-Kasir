@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Detail Produk</h1>
    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-4">{{ $produk->nama }}</h2>
        <p class="mb-2"><strong>Harga Beli:</strong> Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</p>
        <p class="mb-2"><strong>Harga Jual:</strong> Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
        <p class="mb-2"><strong>Stok:</strong> {{ $produk->stok }}</p>
        <p class="mb-2"><strong>Stok Awal:</strong> {{ $produk->stok_awal }}</p>
        <p class="mb-2"><strong>Deskripsi:</strong> {{ $produk->deskripsi ?: 'Tidak ada deskripsi' }}</p>
        <p class="mb-4"><strong>Kategori:</strong> {{ $produk->kategori->nama ?? 'N/A' }}</p>
        <a href="{{ route('produks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kembali</a>
        <a href="{{ route('produks.edit', $produk->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded ml-2">Edit</a>
    </div>
</div>
@endsection