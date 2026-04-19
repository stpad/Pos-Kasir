@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Daftar Produk</h1>
    <a href="{{ route('produks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Tambah Produk</a>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Nama</th>
                    <th class="py-2 px-4 border-b">Harga</th>
                    <th class="py-2 px-4 border-b">Stok</th>
                    <th class="py-2 px-4 border-b">Kategori</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produks as $produk)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $produk->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $produk->nama }}</td>
                    <td class="py-2 px-4 border-b">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">{{ $produk->stok }}</td>
                    <td class="py-2 px-4 border-b">{{ $produk->kategori->nama ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('produks.show', $produk->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">Lihat</a>
                        <a href="{{ route('produks.edit', $produk->id) }}" class="text-yellow-500 hover:text-yellow-700 mr-2">Edit</a>
                        <form action="{{ route('produks.destroy', $produk->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection