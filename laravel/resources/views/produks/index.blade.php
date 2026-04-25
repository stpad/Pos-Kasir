<x-app-layout>
    <div class="min-h-screen bg-gray-50 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Produk</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola data produk toko Anda</p>
                </div>

                <a href="{{ route('produks.create') }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-gray-900 text-white text-sm font-semibold rounded-2xl hover:bg-gray-800 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Produk
                </a>
            </div>

            {{-- Search --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-8">
                <form method="GET" action="{{ route('produks.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama produk..."
                        class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-gray-300 focus:border-gray-300"
                    >

                    <button type="submit"
                            class="px-6 py-3 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-800 transition">
                        Cari
                    </button>

                    @if(request('search'))
                        <a href="{{ route('produks.index') }}"
                           class="px-6 py-3 text-center bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Alert --}}
            @if(session('success'))
                <div class="mb-6 px-5 py-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl">
                    {{ session('success') }}
                </div>
            @endif

            
           {{-- Grid Produk --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($produks as $produk)
        <div
            onclick="window.location='{{ route('produks.show', $produk->id) }}'"
            class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden group cursor-pointer"
        >

            {{-- Gambar --}}
            <div class="relative">
                <div class="aspect-square bg-gray-100 overflow-hidden">
                    @if($produk->gambar)
                        <img
                            src="{{ asset('storage/' . $produk->gambar) }}"
                            alt="{{ $produk->nama }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                        >
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-20 h-20 text-gray-300"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.5"
                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Badge Stok --}}
                <div class="absolute top-4 right-4">
                    @if($produk->stok <= 0)
                        <span class="px-3 py-1 text-xs font-bold text-white bg-red-500 rounded-full">
                            Habis
                        </span>
                    @elseif($produk->stok <= 5)
                        <span class="px-3 py-1 text-xs font-bold text-white bg-yellow-500 rounded-full">
                            Stok Rendah
                        </span>
                    @else
                        <span class="px-3 py-1 text-xs font-bold text-white bg-green-500 rounded-full">
                            {{ $produk->stok }} Stok
                        </span>
                    @endif
                </div>

                {{-- Badge Diskon --}}
                @if($produk->diskon > 0)
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 text-xs font-bold text-white bg-red-600 rounded-full">
                            -{{ $produk->diskon }}%
                        </span>
                    </div>
                @endif
            </div>

            {{-- Konten --}}
            <div class="p-5">
                <div class="mb-4">
                    <h3 class="text-base font-bold text-gray-900 line-clamp-2">
                        {{ $produk->nama }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $produk->kategori->nama ?? 'Tanpa Kategori' }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-2xl font-bold text-gray-900">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </p>

                    @if($produk->harga_beli)
                        <p class="text-xs text-gray-400 mt-1">
                            Modal: Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}
                        </p>
                    @endif
                </div>

                @if($produk->deskripsi)
                    <p class="text-sm text-gray-500 line-clamp-2 mb-5">
                        {{ $produk->deskripsi }}
                    </p>
                @endif

                {{-- Tombol --}}
                <div
                    class="grid grid-cols-2 gap-2 pt-4 border-t border-gray-100"
                    onclick="event.stopPropagation()"
                >
                    <a href="{{ route('produks.edit', $produk->id) }}"
                       class="text-center py-2.5 text-sm font-semibold text-amber-600 bg-amber-50 rounded-xl hover:bg-amber-100 transition">
                        Edit
                    </a>

                    <form action="{{ route('produks.destroy', $produk->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin hapus produk ini?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="w-full py-2.5 text-sm font-semibold text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        {{-- Empty State tetap --}}
    @endforelse
</div>

            {{-- Pagination --}}
            @if($produks->hasPages())
                <div class="mt-10">
                    {{ $produks->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>