@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900">Daftar Kategori</h1>
                    <p class="mt-2 text-sm text-gray-500">Lihat semua kategori dan jumlah produk di masing-masing kategori.</p>
                </div>
                <a href="{{ route('kategoris.create') }}" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Tambah Kategori</a>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-3xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">ID</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Nama</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Deskripsi</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Jumlah Produk</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($kategoris as $kategori)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 text-sm text-gray-700">{{ $kategori->id }}</td>
                        <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $kategori->nama }}</td>
                        <td class="px-4 py-4 text-sm text-gray-600">{{ $kategori->deskripsi ?: 'Tidak ada deskripsi' }}</td>
                        <td class="px-4 py-4 text-sm text-gray-700">{{ $kategori->produks_count }}</td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('kategoris.show', $kategori) }}" class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 hover:bg-blue-200">Lihat</a>
                                <a href="{{ route('kategoris.edit', $kategori) }}" class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700 hover:bg-yellow-200">Edit</a>
                                <form action="{{ route('kategoris.destroy', $kategori) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 hover:bg-red-200" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection