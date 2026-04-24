<x-app-layout>
<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Back Button --}}
        <a href="{{ route('produks.index') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Produk
        </a>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Gambar --}}
                    <div class="lg:col-span-1">
                        <div class="sticky top-4">
                            <div class="bg-gray-100 rounded-xl overflow-hidden mb-4">
                                @if($produk->gambar)
                                    <img src="{{ asset('storage/'.$produk->gambar) }}" alt="{{ $produk->nama }}"
                                         class="w-full h-80 object-cover">
                                @else
                                    <div class="w-full h-80 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Status Badges --}}
                            <div class="flex flex-wrap gap-2 mb-4">
                                @if($produk->stok <= 0)
                                    <span class="inline-block px-3 py-1 bg-red-100 text-red-700 text-sm font-semibold rounded-full">Habis</span>
                                @elseif($produk->stok <= 5)
                                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 text-sm font-semibold rounded-full">⚠️ Stok Rendah</span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded-full">Tersedia</span>
                                @endif
                                
                                @if($produk->diskon > 0)
                                    <span class="inline-block px-3 py-1 bg-red-100 text-red-700 text-sm font-semibold rounded-full">-{{ $produk->diskon }}% Diskon</span>
                                @endif
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex gap-3">
                                <a href="{{ route('produks.edit', $produk->id) }}"
                                   class="flex-1 text-center px-4 py-2.5 bg-amber-500 text-white text-sm font-semibold rounded-lg hover:bg-amber-600 transition">
                                    Edit
                                </a>
                                <form action="{{ route('produks.destroy', $produk->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus produk \'{{ $produk->nama }}\'?')"
                                      class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full px-4 py-2.5 bg-red-500 text-white text-sm font-semibold rounded-lg hover:bg-red-600 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Info --}}
                    <div class="lg:col-span-2">
                        {{-- Header --}}
                        <div class="mb-8 pb-6 border-b border-gray-200">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $produk->nama }}</h1>
                            <p class="text-sm text-gray-500">Kategori: <span class="font-semibold text-gray-700">{{ $produk->kategori->nama ?? '-' }}</span></p>
                        </div>

                        {{-- Harga Section --}}
                        <div class="mb-8 pb-8 border-b border-gray-200">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                {{-- Harga Jual --}}
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Harga Jual</p>
                                    <div class="text-3xl font-bold text-gray-900">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </div>
                                </div>

                                {{-- Harga Beli --}}
                                @if($produk->harga_beli)
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Harga Beli</p>
                                    <div class="text-2xl font-semibold text-gray-700">
                                        Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}
                                    </div>
                                </div>

                                {{-- Margin Keuntungan --}}
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Margin Keuntungan</p>
                                    <div class="text-2xl font-semibold text-green-600">
                                        Rp {{ number_format($produk->harga - $produk->harga_beli, 0, ',', '.') }}
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        ({{ number_format((($produk->harga - $produk->harga_beli) / $produk->harga * 100), 1) }}%)
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Diskon & Stok Section --}}
                        <div class="mb-8 pb-8 border-b border-gray-200">
                            <div class="grid grid-cols-2 gap-6">
                                {{-- Diskon --}}
                                <div>
                                    <p class="text-sm text-gray-500 mb-2">Diskon</p>
                                    <div class="text-2xl font-bold text-red-600">
                                        {{ $produk->diskon ?? 0 }}%
                                    </div>
                                    @if($produk->diskon > 0)
                                    <p class="text-xs text-gray-500 mt-1">
                                        Hemat: Rp {{ number_format(($produk->harga * $produk->diskon / 100), 0, ',', '.') }}
                                    </p>
                                    @endif
                                </div>

                                {{-- Stok --}}
                                <div>
                                    <p class="text-sm text-gray-500 mb-2">Stok</p>
                                    <div class="flex items-baseline gap-2">
                                        <div class="text-2xl font-bold text-gray-900">{{ $produk->stok }}</div>
                                        <span class="text-sm text-gray-500">unit</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        @if($produk->deskripsi)
                        <div>
                            <p class="text-sm text-gray-500 mb-3 font-semibold">Deskripsi</p>
                            <div class="text-gray-700 leading-relaxed whitespace-pre-wrap">
                                {{ $produk->deskripsi }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Meta Info --}}
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-sm">
                        <div>
                            <p class="text-gray-500">Dibuat pada</p>
                            <p class="text-gray-900 font-medium">{{ $produk->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Terakhir diubah</p>
                            <p class="text-gray-900 font-medium">{{ $produk->updated_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">ID Produk</p>
                            <p class="text-gray-900 font-medium font-mono">{{ $produk->id }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>