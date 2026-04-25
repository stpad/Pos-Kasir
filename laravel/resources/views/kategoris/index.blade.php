<x-app-layout>
    <div class="min-h-screen bg-gray-50 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Kategori</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola kategori produk toko Anda</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    {{-- Search --}}
                    <form method="GET"
                          action="{{ route('kategoris.index') }}"
                          class="flex flex-col sm:flex-row gap-3">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari kategori..."
                            class="w-full sm:w-72 px-4 py-3 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-gray-300 focus:border-gray-300"
                        >

                        <button type="submit"
                                class="px-6 py-3 bg-gray-900 text-white text-sm font-semibold rounded-2xl hover:bg-gray-800 transition">
                            Cari
                        </button>

                        @if(request('search'))
                            <a href="{{ route('kategoris.index') }}"
                               class="px-6 py-3 text-center bg-gray-100 text-gray-700 text-sm font-medium rounded-2xl hover:bg-gray-200 transition">
                                Reset
                            </a>
                        @endif
                    </form>

                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('kategoris.create') }}"
                               class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-gray-900 text-white text-sm font-semibold rounded-2xl hover:bg-gray-800 transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Kategori
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Alert --}}
            @if(session('success'))
                <div class="mb-6 px-5 py-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Grid Kategori --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($kategoris as $kategori)
                    <div
                        onclick="window.location='{{ route('kategoris.show', $kategori->id) }}'"
                        class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer"
                    >
                        <div class="p-6">

                            {{-- Icon --}}
                            <div class="w-16 h-16 rounded-2xl bg-gray-900 flex items-center justify-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-8 h-8 text-white"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>

                            {{-- Content --}}
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-3">
                                    {{ $kategori->nama }}
                                </h3>

                                <p class="text-sm text-gray-500 line-clamp-3 min-h-[72px]">
                                    {{ $kategori->deskripsi ?: 'Tidak ada deskripsi untuk kategori ini.' }}
                                </p>
                            </div>

                            {{-- Action --}}
                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <div class="grid grid-cols-3 gap-2 pt-4 border-t border-gray-100"
                                         onclick="event.stopPropagation()">

                                        <a href="{{ route('kategoris.show', $kategori) }}"
                                           class="text-center py-2.5 text-sm font-semibold text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition">
                                            Detail
                                        </a>

                                        <a href="{{ route('kategoris.edit', $kategori) }}"
                                           class="text-center py-2.5 text-sm font-semibold text-amber-600 bg-amber-50 rounded-xl hover:bg-amber-100 transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('kategoris.destroy', $kategori) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="w-full py-2.5 text-sm font-semibold text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth

                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-20 h-20 mx-auto text-gray-300 mb-4"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.5"
                                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>

                            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                Belum Ada Kategori
                            </h3>

                            <p class="text-gray-500">
                                Tambahkan kategori pertama untuk mulai mengelola produk.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if(method_exists($kategoris, 'hasPages') && $kategoris->hasPages())
                <div class="mt-10">
                    {{ $kategoris->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>