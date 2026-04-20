@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('kategoris.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Detail Kategori</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $kategori->nama }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Deskripsi</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $kategori->deskripsi ?? '-' }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Dibuat pada</label>
                        <div class="mt-1 text-sm text-gray-500">{{ $kategori->created_at->format('d M Y H:i') }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Terakhir diperbarui</label>
                        <div class="mt-1 text-sm text-gray-500">{{ $kategori->updated_at->format('d M Y H:i') }}</div>
                    </div>
                </div>

                <div class="mt-6 flex gap-4">
                    @auth
                        @if(Auth::user() && Auth::user()->role === 'admin')
                    <a href="{{ route('kategoris.edit', $kategori) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Edit
                    </a>
                        @endif
                    @endauth
                    <a href="{{ route('kategoris.index') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-50">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection