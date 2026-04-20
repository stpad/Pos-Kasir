@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('kategoris.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Edit Kategori</h2>

                <form action="{{ route('kategoris.update', $kategori) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Perbarui
                        </button>
                        <a href="{{ route('kategoris.index') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-50">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection