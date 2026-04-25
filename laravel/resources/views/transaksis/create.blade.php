@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                Transaksi Baru 🛒
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Pilih produk dan lakukan transaksi dengan mudah.
            </p>
        </div>

        <a href="{{ route('transaksis.index') }}"
            class="inline-flex items-center px-5 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                <!-- Products List -->
               <div class="lg:col-span-2 order-2 lg:order-1">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-4 flex flex-col">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pilih Produk</h3>

                            <!-- Search Produk -->
                            <div class="mb-3">
                                <input type="text" id="searchProduk" placeholder="Cari produk..."
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2">
                            </div>

                            <!-- Products Grid -->
                            <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                                @foreach ($produk as $p)
                                    <button type="button"
                                        onclick="addItem({{ $p->id }}, '{{ $p->nama }}', {{ $p->harga }}, {{ $p->stok }})"
                                        class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-1 hover:border-blue-500 transition-all duration-300 text-left">
                                        <!-- Gambar Produk -->
                                        <div class="h-40 bg-gray-100 overflow-hidden">
                                            @if ($p->gambar)
                                                <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama }}"
                                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <svg class="w-16 h-16" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5"
                                                            d="M20 13V7a2 2 0 00-2-2h-3V3H9v2H6a2 2 0 00-2 2v6m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4m4 4h.01M12 17h.01M16 17h.01">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Content -->
                                        <div class="p-4">
                                            <!-- Nama -->
                                            <h4
                                                class="font-bold text-gray-900 text-lg truncate group-hover:text-blue-600 transition">
                                                {{ $p->nama }}
                                            </h4>

                                            <!-- Kategori -->
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $p->kategori->nama ?? 'Tanpa Kategori' }}
                                            </p>

                                            <!-- Stok -->
                                            <div class="mt-4 flex items-center justify-between">
                                                <span class="text-sm text-gray-500">Stok</span>
                                                <span
                                                    class="px-3 py-1 text-xs font-semibold rounded-full
                        {{ $p->stok <= 10 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                                    {{ $p->stok }}
                                                </span>
                                            </div>

                                            <!-- Harga -->
                                            <div class="mt-4 pt-4 border-t border-gray-100">
                                                <p class="text-2xl font-extrabold text-blue-600">
                                                    Rp {{ number_format($p->harga, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            <div class="flex justify-center">
                                {{ $produk->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart -->
                <div class="lg:col-span-1 order-1 lg:order-2">
                    <div class="sticky top-6 h-[calc(100vh-7rem)]">
                        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 h-full flex flex-col">

                            <!-- Header -->
                            <div class="p-5 border-b border-gray-100">
                                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                    🛒 Keranjang
                                </h3>
                            </div>

                            <form id="transaksiForm" method="POST" action="{{ route('transaksis.store') }}"
                                class="flex flex-col flex-1">
                                @csrf

                                <div id="hiddenInputs"></div>

                                <!-- Isi Keranjang -->
                                <div id="cartItems" class="flex-1 overflow-y-auto p-5 space-y-3">
                                    <p class="text-gray-500 text-center py-10">
                                        Belum ada produk dipilih
                                    </p>
                                </div>

                                <!-- Footer -->
                                <div class="border-t border-gray-100 p-5 space-y-4 bg-gray-50 rounded-b-2xl">

                                    <!-- Total -->
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-semibold text-gray-700">
                                            Total
                                        </span>
                                        <span id="totalHarga" class="text-2xl font-extrabold text-blue-600">
                                            Rp 0
                                        </span>
                                    </div>

                                    <!-- Jumlah Bayar -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Jumlah Bayar
                                        </label>
                                        <input type="number" name="jumlah_bayar" id="jumlahBayar" min="0"
                                            class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                            oninput="hitungKembalian()">
                                    </div>

                                    <!-- Kembalian -->
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-semibold text-gray-700">
                                            Kembalian
                                        </span>
                                        <span id="kembalian" class="text-2xl font-extrabold text-green-600">
                                            Rp 0
                                        </span>
                                    </div>

                                    <!-- Tombol -->
                                    <button type="submit" id="btnSimpan" disabled
                                        class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-4 rounded-xl transition-all duration-300">
                                        Simpan Transaksi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let stokProduk = {}; // Simpan stok untuk setiap produk
        document.getElementById('jumlahBayar').focus();

        function addItem(id, nama, harga, stok, diskon = 0) {
            stokProduk[id] = stok;
            const hargaFinal = harga - (harga * diskon / 100);

            const existing = cart.find(item => item.id === id);

            if (existing) {
                if (existing.jumlah < stok) {
                    existing.jumlah++;
                }
            } else {
                cart.push({
                    id,
                    nama,
                    harga: hargaFinal,
                    hargaAsli: harga,
                    diskon,
                    jumlah: 1
                });
            }

            renderCart();
        }

        function updateJumlah(id, delta) {
            const item = cart.find(i => i.id === id);
            if (item) {
                const newJumlah = item.jumlah + delta;
                // Cek apakah jumlah melebihi stok
                if (newJumlah > stokProduk[id]) {
                    return; // Tidak boleh tambah jika melebihi stok
                }
                item.jumlah = newJumlah;
                if (item.jumlah < 1) {
                    cart = cart.filter(i => i.id !== id);
                }
            }
            renderCart();
        }

        function removeItem(id) {
            cart = cart.filter(item => item.id !== id);
            renderCart();
        }

        function renderCart() {
            const container = document.getElementById('cartItems');
            const totalEl = document.getElementById('totalHarga');
            const btnSimpan = document.getElementById('btnSimpan');
            const hiddenInputs = document.getElementById('hiddenInputs');

            if (cart.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-sm text-center py-4">Belum ada produk dipilih</p>';
                totalEl.textContent = 'Rp 0';
                btnSimpan.disabled = true;
                hiddenInputs.innerHTML = '';
                return;
            }

            let total = 0;
            let inputsHtml = '';
            let adaStokTidakCukup = false;

            container.innerHTML = cart.map(item => {
                const subtotal = item.harga * item.jumlah;
                total += subtotal;

                const stokTidakCukup = item.jumlah > stokProduk[item.id];
                if (stokTidakCukup) {
                    adaStokTidakCukup = true;
                }

                inputsHtml += `<input type="hidden" name="items[${item.id}][produk_id]" value="${item.id}">
                       <input type="hidden" name="items[${item.id}][jumlah]" value="${item.jumlah}">`;

                return `
            <div class="p-2 bg-gray-50 rounded ${stokTidakCukup ? 'border-2 border-red-500' : ''}">
                <div class="flex justify-between items-start gap-2">
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-gray-900 text-xs truncate">${item.nama}</div>
                        <div class="text-xs text-gray-500">Rp ${item.harga.toLocaleString('id-ID')} x ${item.jumlah}</div>
                        ${stokTidakCukup ? '<div class="text-xs text-red-600 font-semibold mt-0.5">⚠️ Stok: ' + stokProduk[item.id] + '</div>' : ''}
                    </div>
                    <div class="flex items-center gap-1">
                        <button type="button" onclick="updateJumlah(${item.id}, -1)" class="w-5 h-5 text-xs rounded bg-gray-200 hover:bg-gray-300">−</button>
                        <span class="w-5 text-center text-xs">${item.jumlah}</span>
                        <button type="button" onclick="updateJumlah(${item.id}, 1)" class="w-5 h-5 text-xs rounded bg-gray-200 hover:bg-gray-300 ${item.jumlah >= stokProduk[item.id] ? 'opacity-50 cursor-not-allowed' : ''}">+</button>
                        <button type="button" onclick="removeItem(${item.id})" class="text-red-500 hover:text-red-700 text-xs ml-1">✕</button>
                    </div>
                </div>
            </div>
        `;
            }).join('');

            hiddenInputs.innerHTML = inputsHtml;
            totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
            hitungKembalian(adaStokTidakCukup);
        }

        function hitungKembalian(adaStokTidakCukup = false) {
            const total = cart.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
            const jumlahBayar = parseInt(document.getElementById('jumlahBayar').value) || 0;
            const kembalian = jumlahBayar - total;

            document.getElementById('kembalian').textContent = 'Rp ' + kembalian.toLocaleString('id-ID');
            document.getElementById('btnSimpan').disabled = kembalian < 0 || cart.length === 0 || adaStokTidakCukup;
        }

        // Search filter
        document.getElementById('searchProduk').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            const buttons = document.querySelectorAll('#productsGrid button');
            buttons.forEach(btn => {
                const nama = btn.querySelector('.font-medium').textContent.toLowerCase();
                btn.style.display = nama.includes(query) ? '' : 'none';
            });
        });
    </script>
@endsection
