@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Edit Kategori</h1>
                <p class="mt-1 text-sm text-slate-600">Perbarui nama atau deskripsi kategori.</p>
            </div>
            <a href="{{ route('kategoris.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200">Kembali ke Kategori</a>
        </div>

        @if ($errors->any())
            <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-900">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kategoris.update', $kategori) }}" method="POST" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="block text-sm font-medium text-slate-700">Nama</label>
                <input id="nama" name="nama" value="{{ old('nama', $kategori->nama) }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-slate-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white hover:bg-sky-700">Perbarui Kategori</button>
                <a href="{{ route('kategoris.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
            </div>
        </form>
    </div>
@endsection
