@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Produk</h2>
            <a href="{{ route('produks.create') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                + Tambah Produk
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if($produks->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-600">Belum ada produk.</p>
                    </div>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($produks as $produk)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $produk->id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $produk->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $produk->stok }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $produk->kategori->nama ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <a href="{{ route('produks.show', $produk) }}" class="text-blue-600 hover:text-blue-900 mr-3">Lihat</a>
                                        <a href="{{ route('produks.edit', $produk) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                        <form action="{{ route('produks.destroy', $produk) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection