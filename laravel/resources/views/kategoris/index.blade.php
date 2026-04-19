@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Daftar Kategori</h1>
    <a href="{{ route('kategoris.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Tambah Kategori</a>
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
                    <th class="py-2 px-4 border-b">Deskripsi</th>
                    <th class="py-2 px-4 border-b">Jumlah Produk</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategoris as $kategori)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $kategori->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $kategori->nama }}</td>
                    <td class="py-2 px-4 border-b">{{ $kategori->deskripsi ?: '-' }}</td>
                    <td class="py-2 px-4 border-b">{{ $kategori->produks->count() }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('kategoris.show', $kategori->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">Lihat</a>
                        <a href="{{ route('kategoris.edit', $kategori->id) }}" class="text-yellow-500 hover:text-yellow-700 mr-2">Edit</a>
                        <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST" class="inline">
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