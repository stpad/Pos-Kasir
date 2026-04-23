@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi Baru') }}
        </h2>
        <a href="{{ route('transaksis.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
            ← Kembali
        </a>
    </div>
@endsection

@section('content')
<div class="py-12">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            
            <!-- Products List -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-4 flex flex-col">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pilih Produk</h3>
                        
                        <!-- Search Produk -->
                        <div class="mb-3">
                            <input 
                                type="text" 
                                id="searchProduk"
                                placeholder="Cari produk..." 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2"
                            >
                        </div>

                        <!-- Products Grid -->
                        <div id="productsGrid" class="grid grid-cols-3 gap-3 mb-4">
                            @foreach($produk as $p)
                                <button 
                                    type="button"
                                    onclick="addItem({{ $p->id }}, '{{ $p->nama }}', {{ $p->harga }}, {{ $p->stok }})"
                                    class="p-3 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition text-left text-sm"
                                >
                                    <div class="font-medium text-gray-900 truncate">{{ $p->nama }}</div>
                                    <div class="text-sm text-gray-500">Stok: {{ $p->stok }}</div>
                                    <div class="text-lg font-bold text-blue-600 mt-1">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
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
            <div class="lg:col-span-1">
                <div class="bg-white shadow-sm sm:rounded-lg sticky top-6">
                    <div class="p-4 flex flex-col">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Keranjang</h3>
                        
                        <form id="transaksiForm" method="POST" action="{{ route('transaksis.store') }}">
                            @csrf
                            <div id="hiddenInputs"></div>
                            <div id="cartItems" class="max-h-64 overflow-y-auto space-y-2 mb-3">
                                <p class="text-gray-500 text-sm text-center py-4">Belum ada produk dipilih</p>
                            </div>

                            <!-- Total -->
                            <div class="border-t pt-3 mb-3">
                                <div class="flex justify-between text-base font-bold">
                                    <span>Total:</span>
                                    <span id="totalHarga">Rp 0</span>
                                </div>
                            </div>

                            <!-- Pembayaran -->
                            <div class="mb-3">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Jumlah Bayar</label>
                                <input 
                                    type="number" 
                                    name="jumlah_bayar" 
                                    id="jumlahBayar"
                                    min="0"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2 text-sm"
                                    oninput="hitungKembalian()"
                                >
                            </div>

                            <!-- Kembalian -->
                            <div class="mb-4">
                                <div class="flex justify-between text-base font-bold">
                                    <span>Kembalian:</span>
                                    <span id="kembalian" class="text-green-600">Rp 0</span>
                                </div>
                            </div>

                            <button 
                                type="submit"
                                id="btnSimpan"
                                disabled
                                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-medium py-2 px-4 rounded-lg transition text-sm"
                            >
                                Simpan Transaksi
                            </button>
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

function addItem(id, nama, harga, stok) {
    stokProduk[id] = stok; // Simpan stok produk
    const existing = cart.find(item => item.id === id);
    if (existing) {
        existing.jumlah++;
    } else {
        cart.push({ id, nama, harga, jumlah: 1 });
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