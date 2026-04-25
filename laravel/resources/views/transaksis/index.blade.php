<x-app-layout>
    <div class="min-h-screen bg-gray-50 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Histori Penjualan</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola seluruh riwayat transaksi penjualan
                    </p>
                </div>

                <a href="{{ route('transaksis.create') }}"
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
                    Transaksi Baru
                </a>
            </div>

            {{-- Search --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 mb-8">
                <form method="GET"
                      action="{{ route('transaksis.index') }}"
                      class="flex flex-col md:flex-row gap-4">

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari kode transaksi atau nama kasir..."
                           class="flex-1 px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-gray-300 focus:border-gray-300">

                    <button type="submit"
                            class="px-6 py-3 bg-gray-900 text-white font-semibold rounded-2xl hover:bg-gray-800 transition">
                        Cari
                    </button>

                    @if(request('search'))
                        <a href="{{ route('transaksis.index') }}"
                           class="px-6 py-3 text-center bg-gray-100 text-gray-700 font-medium rounded-2xl hover:bg-gray-200 transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($transaksis as $transaksi)
                    <div onclick="window.location='{{ route('transaksis.show', $transaksi) }}'"
                         class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">

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
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                                </svg>
                            </div>

                            {{-- Transaction Info --}}
                            <div class="mb-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">
                                    {{ $transaksi->kode_transaksi }}
                                </h3>

                                <p class="text-sm text-gray-500 mb-4">
                                    {{ $transaksi->created_at->format('d M Y, H:i') }}
                                </p>

                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Kasir</span>
                                        <span class="font-medium text-gray-900">
                                            {{ $transaksi->user->name }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Item</span>
                                        <span class="font-medium text-gray-900">
                                            {{ $transaksi->items->count() }} Produk
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Total --}}
                            <div class="mb-6">
                                <p class="text-xs text-gray-500 mb-1">Total Penjualan</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                </p>
                            </div>

                            {{-- Status --}}
                            <div class="mb-6">
                                <span class="inline-flex px-4 py-2 rounded-full text-xs font-semibold
                                    {{ $transaksi->status === 'selesai'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($transaksi->status) }}
                                </span>
                            </div>

                            {{-- Actions --}}
                            <div class="grid grid-cols-2 gap-3 pt-4 border-t border-gray-100"
                                 onclick="event.stopPropagation()">

                                <a href="{{ route('transaksis.show', $transaksi) }}"
                                   class="text-center py-2.5 text-sm font-semibold text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition">
                                    Detail
                                </a>

                                <form action="{{ route('transaksis.destroy', $transaksi) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
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
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                            </svg>

                            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                Belum Ada Transaksi
                            </h3>

                            <p class="text-gray-500">
                                Transaksi penjualan akan muncul di sini.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($transaksis->hasPages())
                <div class="mt-10">
                    {{ $transaksis->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>