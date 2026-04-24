@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="w-min-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Kategori</h2>
            <div class="flex gap-3">
                <form action="{{ route('kategoris.index') }}" method="GET" class="flex">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari kategori..." 
                        class="border border-gray-300 rounded-l-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-800">
                    <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-r-md text-sm font-medium">
                        Cari
                    </button>
                </form>
                @auth
                    @if(Auth::user() && Auth::user()->role === 'admin')
                    <a href="{{ route('kategoris.create') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        + Tambah Kategori
                    </a>
                    @endif
                @endauth
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if($kategoris->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-600">Belum ada kategori.</p>
                    </div>
                @else
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                                @auth
                                    @if(Auth::user() && Auth::user()->role === 'admin')
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    @endif
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($kategoris as $kategori)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $kategori->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $kategori->deskripsi ?? '-' }}</td>
                                    @auth
                                        @if(Auth::user() && Auth::user()->role === 'admin')
                                    <td class="px-6 py-4 text-right text-sm">
                                        <a href="{{ route('kategoris.show', $kategori) }}" class="text-blue-600 hover:text-blue-900 mr-3">Lihat</a>
                                        <a href="{{ route('kategoris.edit', $kategori) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                        <form action="{{ route('kategoris.destroy', $kategori) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus?')">Hapus</button>
                                        </form>
                                    </td>
                                        @endif
                                    @endauth
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