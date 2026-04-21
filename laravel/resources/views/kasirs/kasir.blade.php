<x-app-layout>
<div class="min-h-screen bg-gray-50">
    <div class="flex h-screen overflow-hidden">

        {{-- ===== KIRI: Daftar Produk ===== --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Topbar --}}
            <div class="bg-white border-b border-gray-100 px-6 py-4">
                <input type="text" id="search-input" placeholder="Cari produk atau kategori..."
                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-300">
            </div>

            {{-- Filter Kategori --}}
            <div class="bg-white border-b border-gray-100 px-6 py-3 flex gap-2 overflow-x-auto">
                <button onclick="filterKategori('semua', this)"
                        class="kategori-btn flex-shrink-0 px-4 py-1.5 rounded-full text-sm font-semibold bg-gray-900 text-white transition">
                    Semua
                </button>
                @foreach($kategoris as $kat)
                <button onclick="filterKategori('{{ strtolower($kat->nama) }}', this)"
                        class="kategori-btn flex-shrink-0 px-4 py-1.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition"
                        data-slug="{{ strtolower($kat->nama) }}">
                    {{ $kat->nama }}
                </button>
                @endforeach
            </div>

            {{-- Grid Produk --}}
            <div class="flex-1 overflow-y-auto p-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3" id="produk-grid">
                    @forelse($produks as $produk)
                    <div class="produk-card bg-white rounded-2xl border border-gray-100 shadow-sm p-4
                                {{ $produk->stok > 0 ? 'cursor-pointer hover:shadow-md hover:border-gray-300 active:scale-95' : 'opacity-50 cursor-not-allowed' }}
                                transition-all"
                         data-id="{{ $produk->id }}"
                         data-nama="{{ $produk->nama }}"
                         data-harga="{{ $produk->harga }}"
                         data-stok="{{ $produk->stok }}"
                         data-kategori="{{ strtolower($produk->kategori->nama ?? 'umum') }}"
                         @if($produk->stok > 0) onclick="addToCartLocal(this)" @endif>

                        <div class="flex items-start justify-between gap-2 mb-3">
                            <div class="w-9 h-9 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            @if($produk->stok <= 0)
                            <span class="text-xs font-semibold bg-red-100 text-red-500 px-2 py-0.5 rounded-full">Habis</span>
                            @else
                            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ $produk->stok }} stok</span>
                            @endif
                        </div>

                        <p class="font-semibold text-gray-900 text-sm line-clamp-2 leading-snug mb-1">{{ $produk->nama }}</p>
                        <p class="text-xs text-gray-400 mb-2">{{ $produk->kategori->nama ?? 'Umum' }}</p>
                        <p class="font-bold text-gray-900 text-sm">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    </div>
                    @empty
                    <div class="col-span-4 py-16 text-center text-gray-400">
                        <p class="text-sm">Belum ada produk tersedia.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ===== KANAN: Cart Panel ===== --}}
        <div class="w-80 xl:w-96 bg-white border-l border-gray-100 flex flex-col">

            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-gray-900">Pesanan</h2>
                    <p class="text-xs text-gray-400 mt-0.5" id="cart-meta">0 item</p>
                </div>
                <button onclick="clearCart()"
                        class="text-xs text-red-400 hover:text-red-600 font-medium px-2 py-1 hover:bg-red-50 rounded-lg transition">
                    Hapus Semua
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-5 py-3" id="cart-list">
                <div id="cart-empty" class="flex flex-col items-center justify-center h-full py-16 text-center">
                    <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-400">Klik produk untuk menambahkan</p>
                </div>
            </div>

            <div class="border-t border-gray-100 px-5 py-4 space-y-2">
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Subtotal</span>
                    <span id="subtotal-display">Rp 0</span>
                </div>
                <div class="flex justify-between font-bold text-gray-900">
                    <span>Total</span>
                    <span id="total-display" class="text-lg">Rp 0</span>
                </div>
            </div>

            <div class="px-5 pb-6">
                <button id="bayar-btn" onclick="checkout()"
                        class="w-full bg-gray-900 text-white py-3.5 rounded-2xl font-bold text-sm hover:bg-gray-700 transition disabled:opacity-40 disabled:cursor-not-allowed"
                        disabled>
                    Bayar Sekarang
                </button>
            </div>
        </div>

    </div>
</div>

<div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-sm px-5 py-3 rounded-2xl shadow-lg transition-all duration-300 opacity-0 pointer-events-none z-50"></div>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

// Gunakan Map agar key selalu konsisten
let cart = new Map();

function formatRp(n) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(n));
}

let toastTimer;
function showToast(msg, isError = false) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.style.opacity = '1';
    t.style.backgroundColor = isError ? '#ef4444' : '#1f2937';
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => {
        t.style.opacity = '0';
        t.style.backgroundColor = '#1f2937';
    }, 2000);
}

// Load cart dari localStorage saat halaman dimuat
function loadCartFromStorage() {
    const savedCart = localStorage.getItem('pos_cart');
    if (savedCart) {
        try {
            const cartArray = JSON.parse(savedCart);
            cart = new Map(cartArray);
            renderCart();
        } catch(e) {
            console.error('Gagal load cart:', e);
        }
    }
}

// Save cart ke localStorage
function saveCartToStorage() {
    const cartArray = Array.from(cart.entries());
    localStorage.setItem('pos_cart', JSON.stringify(cartArray));
}

function addToCartLocal(el) {
    const id    = String(el.dataset.id);
    const nama  = el.dataset.nama;
    const harga = parseFloat(el.dataset.harga);
    const stok  = parseInt(el.dataset.stok);
    
    // Cek stok maksimal
    let currentQty = cart.has(id) ? cart.get(id).qty : 0;
    
    if (currentQty >= stok) {
        showToast(`Stok ${nama} hanya ${stok}!`, true);
        return;
    }
    
    if (cart.has(id)) {
        const item = cart.get(id);
        item.qty++;
        cart.set(id, item);
    } else {
        cart.set(id, { id, nama, harga, stok, qty: 1 });
    }
    
    saveCartToStorage();
    renderCart();
    showToast(`✓ ${nama} ditambahkan`);
}

function changeQty(id, delta) {
    id = String(id);
    if (!cart.has(id)) return;
    
    const item = cart.get(id);
    const newQty = item.qty + delta;
    
    if (newQty <= 0) {
        cart.delete(id);
        showToast(`✗ ${item.nama} dihapus`);
    } else if (newQty > item.stok) {
        showToast(`Stok ${item.nama} hanya ${item.stok}!`, true);
        return;
    } else {
        item.qty = newQty;
        cart.set(id, item);
    }
    
    saveCartToStorage();
    renderCart();
}

function removeFromCart(id) {
    id = String(id);
    if (!cart.has(id)) return;
    
    const item = cart.get(id);
    cart.delete(id);
    saveCartToStorage();
    renderCart();
    showToast(`✗ ${item.nama} dihapus`);
}

function clearCart() {
    if (!cart.size) return;
    if (confirm('Hapus semua item dari keranjang?')) {
        cart.clear();
        saveCartToStorage();
        renderCart();
        showToast('Keranjang dikosongkan');
    }
}

function renderCart() {
    const list  = document.getElementById('cart-list');
    const empty = document.getElementById('cart-empty');
    const items = Array.from(cart.values());
    
    const totalQty = items.reduce((s, i) => s + i.qty, 0);
    const total    = items.reduce((s, i) => s + (i.harga * i.qty), 0);
    
    const bayarBtn = document.getElementById('bayar-btn');
    if (bayarBtn) {
        bayarBtn.disabled = items.length === 0;
    }
    
    const cartMeta = document.getElementById('cart-meta');
    if (cartMeta) {
        cartMeta.textContent = totalQty + ' item';
    }
    
    const subtotalDisplay = document.getElementById('subtotal-display');
    const totalDisplay = document.getElementById('total-display');
    
    if (subtotalDisplay) subtotalDisplay.textContent = formatRp(total);
    if (totalDisplay) totalDisplay.textContent = formatRp(total);
    
    if (!items.length) {
        if (list && empty) {
            list.innerHTML = '';
            list.appendChild(empty);
            empty.style.display = 'flex';
        }
        return;
    }
    
    if (empty) empty.style.display = 'none';
    if (list) {
        list.innerHTML = items.map(item => `
            <div class="flex items-center gap-3 py-2.5 border-b border-gray-50 last:border-0">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 line-clamp-1">${escHtml(item.nama)}</p>
                    <p class="text-xs text-gray-400">${formatRp(item.harga)}</p>
                    <p class="text-xs text-gray-400">Stok: ${item.stok}</p>
                </div>
                <div class="flex items-center gap-1">
                    <button onclick="changeQty('${item.id}',-1)" class="w-6 h-6 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-bold text-gray-600 flex items-center justify-center">−</button>
                    <span class="w-7 text-center text-sm font-semibold">${item.qty}</span>
                    <button onclick="changeQty('${item.id}',1)" class="w-6 h-6 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-bold text-gray-600 flex items-center justify-center">+</button>
                </div>
                <p class="text-sm font-bold text-gray-900 min-w-[72px] text-right">${formatRp(item.harga * item.qty)}</p>
                <button onclick="removeFromCart('${item.id}')" class="text-gray-300 hover:text-red-400 transition ml-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        `).join('');
    }
}

function escHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
}

async function checkout() {
    const items = Array.from(cart.values());
    if (!items.length) {
        showToast('Keranjang masih kosong!', true);
        return;
    }
    
    const btn = document.getElementById('bayar-btn');
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Memproses...';
    
    try {
        // 1. Cek stok dulu
        const cekRes = await fetch('/check-stok-batch', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: JSON.stringify({ items: items.map(i => ({ id: i.id, qty: i.qty })) }),
        });
        
        const cekData = await cekRes.json();
        if (!cekRes.ok || !cekData.success) {
            showToast(cekData.message || 'Stok tidak mencukupi!', true);
            btn.disabled = false;
            btn.textContent = originalText;
            return;
        }

        // 2. Clear cart DB dulu biar tidak dobel
        await fetch('/cart/clear', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        
        // 3. Kirim item ke cart DB
        for (const item of items) {
            const res = await fetch('/cart/add', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: JSON.stringify({ product_id: item.id, quantity: item.qty }),
            });
            
            const data = await res.json();
            if (!res.ok) {
                showToast(data.error || `Gagal menambah ${item.nama}`, true);
                btn.disabled = false;
                btn.textContent = originalText;
                return;
            }
        }
        
        // 4. Clear localStorage setelah sukses
        cart.clear();
        saveCartToStorage();
        renderCart();
        
        showToast('Berhasil, mengalihkan ke halaman cart...');
        setTimeout(() => { window.location.href = '/cart'; }, 1000);
        
    } catch (error) {
        showToast('Terjadi kesalahan: ' + error.message, true);
        btn.disabled = false;
        btn.textContent = originalText;
    }
}

// Search dengan filter yang sudah ada
document.getElementById('search-input')?.addEventListener('input', function() {
    const q = this.value.toLowerCase().trim();
    const activeKategori = document.querySelector('.kategori-btn.bg-gray-900')?.dataset.slug || 'semua';
    
    document.querySelectorAll('.produk-card').forEach(card => {
        const matchNama = card.dataset.nama.toLowerCase().includes(q);
        const matchKategori = activeKategori === 'semua' || card.dataset.kategori === activeKategori;
        const shouldShow = matchNama && matchKategori;
        card.style.display = shouldShow ? '' : 'none';
    });
});

// Filter kategori
function filterKategori(slug, btn) {
    // Update button styles
    document.querySelectorAll('.kategori-btn').forEach(b => {
        b.classList.remove('bg-gray-900', 'text-white');
        b.classList.add('bg-gray-100', 'text-gray-600');
        if (b === btn) {
            b.classList.remove('bg-gray-100', 'text-gray-600');
            b.classList.add('bg-gray-900', 'text-white');
        }
    });
    
    // Update dataset slug untuk button aktif
    const activeBtn = document.querySelector('.kategori-btn.bg-gray-900');
    if (activeBtn) {
        activeBtn.dataset.slug = slug;
    }
    
    // Apply filter
    const searchQuery = document.getElementById('search-input')?.value.toLowerCase().trim() || '';
    
    document.querySelectorAll('.produk-card').forEach(card => {
        const matchKategori = slug === 'semua' || card.dataset.kategori === slug;
        const matchSearch = card.dataset.nama.toLowerCase().includes(searchQuery);
        card.style.display = (matchKategori && matchSearch) ? '' : 'none';
    });
}

// Inisialisasi saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    loadCartFromStorage();
    
    // Set initial dataset untuk button Semua
    const semuaBtn = document.querySelector('.kategori-btn.bg-gray-900');
    if (semuaBtn) {
        semuaBtn.dataset.slug = 'semua';
    }
    
    console.log('POS page loaded, cart size:', cart.size);
});
</script>
</x-app-layout>