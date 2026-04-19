@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Detail Kategori</h1>
    <div class="bg-white p-6 rounded shadow-md mb-6">
        <h2 class="text-2xl font-bold mb-4">{{ $kategori->nama }}</h2>
        <p class="mb-2">{{ $kategori->deskripsi ?: 'Tidak ada deskripsi' }}</p>
        <p class="text-sm text-gray-500">Dibuat pada: {{ $kategori->created_at->format('d M Y') }}</p>
    </div>

    <h2 class="text-2xl font-bold mb-4">Produk dalam Kategori Ini</h2>
    @if($kategori->produks->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b">Nama Produk</th>
                        <th class="py-2 px-4 border-b">Harga</th>
                        <th class="py-2 px-4 border-b">Stok</th>
                        <th class="py-2 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategori->produks as $produk)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $produk->nama }}</td>
                        <td class="py-2 px-4 border-b">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b">{{ $produk->stok }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('produks.show', $produk->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">Lihat</a>
                            <a href="{{ route('produks.edit', $produk->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">Belum ada produk dalam kategori ini.</p>
    @endif

    <div class="mt-6">
        <a href="{{ route('kategoris.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kembali</a>
        <a href="{{ route('produks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">Tambah Produk</a>
    </div>
</div>
@endsection