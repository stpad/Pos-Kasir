<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Produk</h2>
                <div class="flex gap-3">
                    {{-- Search Form --}}
                    <form action="{{ route('produks.index') }}" method="GET" class="flex">
                        <input type="text" name="search" value="{{ request('search') ?? '' }}" placeholder="Cari produk..." 
                            class="border border-gray-300 rounded-l-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-800">
                        <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-r-md text-sm font-medium">
                            Cari
                        </button>
                    </form>

                    {{-- Tombol Cart --}}
                    <button onclick="openCart()"
                        class="relative flex items-center gap-2 bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        🛒
                        <span id="cartBadge"
                            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 items-center justify-center"
                            style="display: none;">
                            0
                        </span>
                        Keranjang
                    </button>

                    {{-- Tombol Tambah Produk (Admin Only) --}}
                    @can('admin')
                    <a href="{{ route('produks.create') }}" 
                        class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        + Tambah Produk
                    </a>
                    @endcan
                </div>
            </div>

            @if (session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($produks->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-600">Belum ada produk.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($produks as $produk)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $produk->nama }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <span class="{{ $produk->stok <= 5 ? 'text-red-600 font-semibold' : '' }}">
                                                    {{ $produk->stok }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $produk->kategori->nama ?? '-' }}</td>
                                            <td class="px-6 py-4 text-right text-sm space-x-2 whitespace-nowrap">
                                                {{-- Tombol + Keranjang --}}
                                                @if($produk->stok > 0)
                                                <button onclick="addToCart({{ $produk->id }}, '{{ addslashes($produk->nama) }}')"
                                                    class="text-green-600 hover:text-green-800 font-medium">+ Cart</button>
                                                @else
                                                <span class="text-gray-300 text-xs">Habis</span>
                                                @endif

                                                <a href="{{ route('produks.show', $produk) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                                
                                                @can('admin')
                                                <a href="{{ route('produks.edit', $produk) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                <form action="{{ route('produks.destroy', $produk) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $produks->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ======================== MODAL CART ======================== --}}
    <div id="cartModal" class="fixed inset-0 z-50 items-center justify-center" style="display: none;">
        <div class="absolute inset-0 bg-black/50" onclick="closeCart()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 flex flex-col max-h-[85vh]">
            <div class="flex items-center justify-between p-5 border-b">
                <h2 class="text-lg font-bold">🛒 Keranjang Belanja</h2>
                <button onclick="closeCart()" class="text-gray-400 hover:text-gray-700 text-2xl leading-none">&times;</button>
            </div>
            <div id="cartLoading" class="p-10 text-center text-gray-400 text-sm">Memuat...</div>
            <div id="cartContent" class="flex-1 overflow-y-auto p-5 space-y-3" style="display: none;"></div>
            <div id="cartEmpty" class="p-10 text-center text-gray-400" style="display: none;">
                <p class="text-4xl mb-2">🛒</p>
                <p class="text-sm">Keranjang masih kosong</p>
            </div>
            <div id="cartFooter" class="p-5 border-t" style="display: none;">
                <div class="flex justify-between font-bold text-lg mb-4">
                    <span>Total</span>
                    <span id="cartTotal">Rp 0</span>
                </div>
                <button onclick="checkout()"
                    class="w-full bg-gray-900 text-white py-3 rounded-xl font-semibold hover:bg-gray-700 transition">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>

    <script>
        const CART_INDEX_URL  = "{{ route('cart.index') }}";
        const CART_ADD_URL    = "{{ route('cart.add') }}";
        const CART_UPDATE_URL = (id) => `/cart/update/${id}`;
        const CART_REMOVE_URL = (id) => `/cart/remove/${id}`;
        const CSRF            = "{{ csrf_token() }}";

        function openCart() {
            const modal = document.getElementById('cartModal');
            modal.style.display = 'flex';
            loadCart();
        }
        
        function closeCart() {
            document.getElementById('cartModal').style.display = 'none';
        }

        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeCart(); });

        async function loadCart() {
            show('cartLoading'); hide('cartContent'); hide('cartEmpty'); hide('cartFooter');
            const data = await fetchJSON(CART_INDEX_URL, 'GET');
            if (!data) return;
            renderCart(data);
        }

        function renderCart(data) {
            hide('cartLoading');
            updateBadge(data.count);

            if (data.items.length === 0) {
                show('cartEmpty'); hide('cartFooter'); hide('cartContent');
                return;
            }

            show('cartContent'); show('cartFooter'); hide('cartEmpty');
            document.getElementById('cartTotal').textContent = formatRp(data.total);
            document.getElementById('cartContent').innerHTML = data.items.map(item => `
                <div class="flex items-center gap-3 border rounded-xl p-3" id="cartItem-${item.id}">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm text-gray-900 truncate">${escapeHtml(item.nama)}</p>
                        <p class="text-xs text-gray-500">${formatRp(item.harga)} × ${item.quantity} = <span class="font-semibold text-gray-700">${formatRp(item.subtotal)}</span></p>
                    </div>
                    <div class="flex items-center gap-1 shrink-0">
                        <button onclick="updateQty(${item.id}, ${item.quantity - 1})"
                            class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-bold">−</button>
                        <span class="w-6 text-center text-sm font-medium">${item.quantity}</span>
                        <button onclick="updateQty(${item.id}, ${item.quantity + 1})"
                            class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-bold">+</button>
                        <button onclick="removeItem(${item.id})"
                            class="w-7 h-7 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 text-xs ml-1">✕</button>
                    </div>
                </div>
            `).join('');
        }

        async function addToCart(productId, nama) {
            const data = await fetchJSON(CART_ADD_URL, 'POST', { product_id: productId, quantity: 1 });
            if (!data) return;
            updateBadge(data.cart.count);
            showToast(`✓ ${nama} ditambahkan ke keranjang!`);
        }

        async function updateQty(id, qty) {
            if (qty < 0) return;
            const data = await fetchJSON(CART_UPDATE_URL(id), 'POST', { quantity: qty });
            if (!data) return;
            renderCart(data.cart);
        }

        async function removeItem(id) {
            if (!confirm('Hapus item dari keranjang?')) return;
            const data = await fetchJSON(CART_REMOVE_URL(id), 'DELETE');
            if (!data) return;
            renderCart(data.cart);
        }

        function checkout() {
            // Redirect ke halaman checkout
            window.location.href = "{{ route('cart.index') }}";
        }

        async function fetchJSON(url, method, body = null) {
            try {
                const res = await fetch(url, {
                    method,
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': CSRF, 
                        'Accept': 'application/json' 
                    },
                    body: body ? JSON.stringify(body) : null,
                });
                const json = await res.json();
                if (!res.ok) { 
                    showToast(json.error || 'Terjadi kesalahan', 'error'); 
                    return null; 
                }
                return json;
            } catch (e) {
                console.error('Fetch error:', e);
                showToast('Gagal terhubung ke server', 'error');
                return null;
            }
        }

        function formatRp(n) {
            return 'Rp ' + Number(n).toLocaleString('id-ID');
        }

        function updateBadge(count) {
            const badge = document.getElementById('cartBadge');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'flex' : 'none';
            }
        }

        function show(id) { 
            const el = document.getElementById(id);
            if (el) el.style.display = 'block';
        }
        
        function hide(id) { 
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        }

        function showToast(msg, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-5 right-5 z-[9999] px-4 py-3 rounded-xl text-white text-sm shadow-lg transition-all
                ${type === 'error' ? 'bg-red-500' : 'bg-gray-900'}`;
            toast.textContent = msg;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2500);
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        // Load badge saat halaman pertama dibuka
        fetchJSON(CART_INDEX_URL, 'GET').then(data => { if (data) updateBadge(data.count); });
    </script>
</x-app-layout>