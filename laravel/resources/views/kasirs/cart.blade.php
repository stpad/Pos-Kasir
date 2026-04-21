<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Tombol Kembali --}}
        <div class="mb-4">
            <a href="{{ route('pos.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 hover:text-gray-900 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke POS
            </a>
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h1 class="text-xl font-bold text-gray-900">Keranjang Belanja</h1>
                <p class="text-sm text-gray-500 mt-1">Review pesanan Anda sebelum checkout</p>
            </div>
            
            <div class="divide-y divide-gray-100">
                @forelse($items as $item)
                <div class="px-6 py-4 flex items-center gap-4">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900">{{ $item['nama'] }}</h3>
                        <p class="text-sm text-gray-500">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2">
                            <button onclick="updateQty({{ $item['id'] }}, {{ $item['quantity'] - 1 }})" 
                                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 transition">
                                -
                            </button>
                            <span class="w-12 text-center font-semibold">{{ $item['quantity'] }}</span>
                            <button onclick="updateQty({{ $item['id'] }}, {{ $item['quantity'] + 1 }})" 
                                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 transition">
                                +
                            </button>
                        </div>
                        <p class="font-bold text-gray-900 min-w-[100px] text-right">
                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </p>
                        <button onclick="removeItem({{ $item['id'] }})" 
                                class="text-red-400 hover:text-red-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                @empty
                <div class="px-6 py-16 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="text-gray-400">Keranjang belanja kosong</p>
                    <a href="{{ route('pos.index') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-lg text-sm hover:bg-gray-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Mulai Belanja
                    </a>
                </div>
                @endforelse
            </div>
            
            @if($items->count() > 0)
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600">Total</span>
                    <span class="text-2xl font-bold text-gray-900">
                        Rp {{ number_format($items->sum('subtotal'), 0, ',', '.') }}
                    </span>
                </div>
                <div class="flex gap-3">
                    
                    <button onclick="processCheckout()" 
                            class="flex-1 bg-gray-900 text-white py-3 rounded-xl font-semibold hover:bg-gray-700 transition">
                        Proses Pembayaran
                    </button>
                </div>
            </div>
            @endif
        </div>
        
    </div>
</div>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

function showToast(msg, isError = false) {
    // Cek apakah ada elemen toast, jika tidak pakai alert
    const toast = document.getElementById('toast');
    if (toast) {
        toast.textContent = msg;
        toast.style.opacity = '1';
        toast.style.backgroundColor = isError ? '#ef4444' : '#1f2937';
        setTimeout(() => {
            toast.style.opacity = '0';
        }, 2000);
    } else {
        alert(msg);
    }
}

async function updateQty(cartId, newQty) {
    if (newQty <= 0) {
        if (!confirm('Hapus item ini?')) return;
        await removeItem(cartId);
        return;
    }
    
    try {
        const response = await fetch(`/cart/update/${cartId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: newQty }),
        });
        
        const data = await response.json();
        
        if (response.ok) {
            window.location.reload();
        } else {
            showToast(data.error || 'Gagal update quantity', true);
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', true);
    }
}

async function removeItem(cartId) {
    try {
        const response = await fetch(`/cart/remove/${cartId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
        });
        
        if (response.ok) {
            window.location.reload();
        } else {
            const data = await response.json();
            showToast(data.error || 'Gagal hapus item', true);
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', true);
    }
}

async function processCheckout() {
    if (!confirm('Konfirmasi pembayaran?')) return;
    
    const btn = event.target;
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Memproses...';
    
    try {
        // Ambil semua item dari cart
        const items = @json($items->toArray());
        
        // Cek stok terlebih dahulu
        const cekRes = await fetch('/check-stok-batch', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                items: items.map(item => ({ id: item.product_id, qty: item.quantity })) 
            }),
        });
        
        const cekData = await cekRes.json();
        
        if (!cekRes.ok || !cekData.success) {
            showToast(cekData.message || 'Stok tidak mencukupi!', true);
            btn.disabled = false;
            btn.textContent = originalText;
            return;
        }
        
        // Redirect ke halaman pembayaran
        showToast('Redirect ke halaman pembayaran...');
        setTimeout(() => {
            window.location.href = '/checkout';
        }, 1000);
        
    } catch (error) {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', true);
        btn.disabled = false;
        btn.textContent = originalText;
    }
}
</script>

{{-- Toast Notification --}}
<div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-sm px-5 py-3 rounded-2xl shadow-lg transition-all duration-300 opacity-0 pointer-events-none z-50"></div>

</x-app-layout>