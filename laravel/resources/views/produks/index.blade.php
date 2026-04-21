<x-app-layout>
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Produk</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola data produk</p>
            </div>
            <a href="{{ route('produks.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-700 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                + Tambah Produk
            </a>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('produks.index') }}" class="flex gap-3 mb-6">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari produk..."
                   class="flex-1 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 shadow-sm">
            <button type="submit"
                    class="px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-700 transition shadow-sm">
                Cari
            </button>
            @if(request('search'))
            <a href="{{ route('produks.index') }}"
               class="px-4 py-2.5 bg-white border border-gray-200 text-sm text-gray-600 rounded-xl hover:bg-gray-50 transition shadow-sm">
                Reset
            </a>
            @endif
        </form>

        {{-- Alert --}}
        @if(session('success'))
        <div class="mb-5 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 font-medium">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 font-medium">
            {{ session('error') }}
        </div>
        @endif

        {{-- Tabel --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider w-8">#</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Harga</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Stok</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Kategori</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produks as $produk)
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $produk->nama }}</p>
                            @if($produk->deskripsi)
                            <p class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $produk->deskripsi }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-700 font-medium">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                {{ $produk->stok > 10 ? 'bg-green-50 text-green-700' : ($produk->stok > 0 ? 'bg-yellow-50 text-yellow-700' : 'bg-red-50 text-red-600') }}">
                                {{ $produk->stok }} pcs
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $produk->kategori->nama ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('produks.show', $produk->id) }}"
                                   class="px-3 py-1.5 text-xs font-semibold text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                    Lihat
                                </a>
                                <a href="{{ route('produks.edit', $produk->id) }}"
                                   class="px-3 py-1.5 text-xs font-semibold text-amber-600 hover:bg-amber-50 rounded-lg transition">
                                    Edit
                                </a>
                                <form action="{{ route('produks.destroy', $produk->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus produk \'{{ $produk->nama }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 text-xs font-semibold text-red-500 hover:bg-red-50 rounded-lg transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="text-sm text-gray-400">
                                {{ request('search') ? 'Produk "'.request('search').'" tidak ditemukan.' : 'Belum ada produk.' }}
                            </p>
                            @if(!request('search'))
                            <a href="{{ route('produks.create') }}"
                               class="mt-3 inline-block text-sm text-gray-900 font-semibold underline">
                                Tambah produk pertama
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($produks->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $produks->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
</x-app-layout>