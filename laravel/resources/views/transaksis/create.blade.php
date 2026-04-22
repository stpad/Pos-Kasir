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
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Products List -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pilih Produk</h3>
                        
                        <!-- Search Produk -->
                        <div class="mb-4">
                            <input 
                                type="text" 
                                id="searchProduk"
                                placeholder="Cari produk..." 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2"
                            >
                        </div>

                        <!-- Products Grid -->
                        <div id="productsGrid" class="grid grid-cols-2 md:grid-cols-3 gap-4 max-h-96 overflow-y-auto">
                            @foreach(\App\Models\Produk::where('stok', '>', 0)->get() as $produk)
                                <button 
                                    type="button"
                                    onclick="addItem({{ $produk->id }}, '{{ $produk->nama }}', {{ $produk->harga }}, {{ $produk->stok }})"
                                    class="p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition text-left"
                                >
                                    <div class="font-medium text-gray-900 truncate">{{ $produk->nama }}</div>
                                    <div class="text-sm text-gray-500">Stok: {{ $produk->stok }}</div>
                                    <div class="text-lg font-bold text-blue-600 mt-1">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart -->
            <div class="lg:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Keranjang</h3>
                        
                        <form id="transaksiForm" method="POST" action="{{ route('transaksis.store') }}">
                            @csrf
                            <div id="hiddenInputs"></div>
                            <div id="cartItems" class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                                <p class="text-gray-500 text-sm text-center py-4">Belum ada produk dipilih</p>
                            </div>

                            <!-- Total -->
                            <div class="border-t pt-4 mb-4">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total:</span>
                                    <span id="totalHarga">Rp 0</span>
                                </div>
                            </div>

                            <!-- Pembayaran -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Bayar</label>
                                <input 
                                    type="number" 
                                    name="jumlah_bayar" 
                                    id="jumlahBayar"
                                    min="0"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2"
                                    oninput="hitungKembalian()"
                                >
                            </div>

                            <!-- Kembalian -->
                            <div class="mb-6">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Kembalian:</span>
                                    <span id="kembalian" class="text-green-600">Rp 0</span>
                                </div>
                            </div>

                            <button 
                                type="submit"
                                id="btnSimpan"
                                disabled
                                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-medium py-3 px-4 rounded-lg transition"
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
            <div class="p-3 bg-gray-50 rounded-lg ${stokTidakCukup ? 'border-2 border-red-500' : ''}">
                <div class="flex justify-between items-center">
                    <div class="flex-1">
                        <div class="font-medium text-gray-900">${item.nama}</div>
                        <div class="text-sm text-gray-500">Rp ${item.harga.toLocaleString('id-ID')} x ${item.jumlah}</div>
                        ${stokTidakCukup ? '<div class="text-sm text-red-600 font-semibold mt-1">⚠️ Stok hanya tersedia: ' + stokProduk[item.id] + '</div>' : ''}
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="updateJumlah(${item.id}, -1)" class="w-6 h-6 rounded bg-gray-200 hover:bg-gray-300">-</button>
                        <span class="w-8 text-center">${item.jumlah}</span>
                        <button type="button" onclick="updateJumlah(${item.id}, 1)" class="w-6 h-6 rounded bg-gray-200 hover:bg-gray-300 ${item.jumlah >= stokProduk[item.id] ? 'opacity-50 cursor-not-allowed' : ''}">+</button>
                        <button type="button" onclick="removeItem(${item.id})" class="text-red-500 hover:text-red-700 ml-2">✕</button>
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