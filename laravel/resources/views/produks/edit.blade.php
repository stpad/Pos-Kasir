@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-3xl font-bold mb-6">Edit Produk</h1>

        @if($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <div class="font-semibold mb-2">Ada beberapa masalah dengan input Anda:</div>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produks.update', $produk->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input
                    id="nama"
                    name="nama"
                    value="{{ old('nama', $produk->nama) }}"
                    class="mt-1 block w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 {{ $errors->has('nama') ? 'border-red-400 ring-red-200' : 'border-gray-300' }}"
                    type="text"
                    required
                >
                @error('nama')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="harga_beli" class="block text-sm font-medium text-gray-700">Harga Beli</label>
                <input
                    id="harga_beli"
                    name="harga_beli"
                    value="{{ old('harga_beli', $produk->harga_beli) }}"
                    inputmode="decimal"
                    step="0.01"
                    class="mt-1 block w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 {{ $errors->has('harga_beli') ? 'border-red-400 ring-red-200' : 'border-gray-300' }}"
                    type="number"
                    required
                >
                @error('harga_beli')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700">Harga Jual</label>
                <input
                    id="harga"
                    name="harga"
                    value="{{ old('harga', $produk->harga) }}"
                    inputmode="decimal"
                    step="0.01"
                    class="mt-1 block w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 {{ $errors->has('harga') ? 'border-red-400 ring-red-200' : 'border-gray-300' }}"
                    type="number"
                    required
                >
                @error('harga')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                <input
                    id="stok"
                    name="stok"
                    value="{{ old('stok', $produk->stok) }}"
                    class="mt-1 block w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 {{ $errors->has('stok') ? 'border-red-400 ring-red-200' : 'border-gray-300' }}"
                    type="number"
                    required
                >
                @error('stok')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stok_awal" class="block text-sm font-medium text-gray-700">Stok Awal</label>
                <input
                    id="stok_awal"
                    name="stok_awal"
                    value="{{ old('stok_awal', $produk->stok_awal) }}"
                    class="mt-1 block w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 {{ $errors->has('stok_awal') ? 'border-red-400 ring-red-200' : 'border-gray-300' }}"
                    type="number"
                    required
                >
                @error('stok_awal')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select
                    id="kategori_id"
                    name="kategori_id"
                    class="mt-1 block w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 {{ $errors->has('kategori_id') ? 'border-red-400 ring-red-200' : 'border-gray-300' }}"
                    required
                >
                    <option value="">Pilih kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id', $produk->kategori_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="4"
                    class="mt-1 block w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 {{ $errors->has('deskripsi') ? 'border-red-400 ring-red-200' : 'border-gray-300' }}"
                >{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('produks.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">Batal</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Perbarui Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection