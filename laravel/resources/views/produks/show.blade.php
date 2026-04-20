@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('produks.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Detail Produk</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama Produk</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $produk->nama }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Harga</label>
                        <div class="mt-1 text-sm text-gray-900">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Stok</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $produk->stok }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Kategori</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $produk->kategori->nama ?? '-' }}</div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500">Deskripsi</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $produk->deskripsi ?? '-' }}</div>
                    </div>
                </div>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('produks.edit', $produk) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Edit
                    </a>
                    <a href="{{ route('produks.index') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-50">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection