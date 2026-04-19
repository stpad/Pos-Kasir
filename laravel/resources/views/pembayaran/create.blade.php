@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Input Pembayaran</h1>
                <p class="mt-1 text-sm text-slate-600">Masukkan jumlah pembayaran dan lihat kembalian secara langsung.</p>
            </div>
            <a href="{{ route('produks.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200">Kembali ke Produk</a>
        </div>

        @if(session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-900">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pembayaran.store') }}" method="POST" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="total" class="block text-sm font-medium text-slate-700">Total Tagihan</label>
                    <input id="total" name="total" type="number" min="0" step="0.01" value="{{ old('total', session('payment.total', 0)) }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
                </div>
                <div>
                    <label for="dibayar" class="block text-sm font-medium text-slate-700">Jumlah Dibayarkan</label>
                    <input id="dibayar" name="dibayar" type="number" min="0" step="0.01" value="{{ old('dibayar', session('payment.dibayar', 0)) }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="metode" class="block text-sm font-medium text-slate-700">Metode Pembayaran</label>
                    <select id="metode" name="metode" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100">
                        <option value="">Pilih metode</option>
                        <option value="tunai" {{ old('metode', session('payment.metode')) == 'tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="debit" {{ old('metode', session('payment.metode')) == 'debit' ? 'selected' : '' }}>Debit</option>
                        <option value="transfer" {{ old('metode', session('payment.metode')) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                </div>
                <div>
                    <label for="catatan" class="block text-sm font-medium text-slate-700">Catatan</label>
                    <input id="catatan" name="catatan" type="text" value="{{ old('catatan', session('payment.catatan')) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex items-center justify-between text-sm text-slate-600">
                    <span>Total tagihan</span>
                    <span class="font-semibold text-slate-900" id="displayTotal">Rp 0</span>
                </div>
                <div class="mt-3 flex items-center justify-between text-sm text-slate-600">
                    <span>Dibayar</span>
                    <span class="font-semibold text-slate-900" id="displayPaid">Rp 0</span>
                </div>
                <div class="mt-3 flex items-center justify-between text-sm text-slate-600">
                    <span>Kembalian</span>
                    <span class="font-semibold text-emerald-700" id="displayChange">Rp 0</span>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white hover:bg-sky-700">Proses Pembayaran</button>
                <button type="button" id="resetPayment" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function formatRupiah(value) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value);
            }

            function updatePaymentSummary() {
                const total = Number(document.getElementById('total').value) || 0;
                const dibayar = Number(document.getElementById('dibayar').value) || 0;
                const kembalian = Math.max(0, dibayar - total);

                document.getElementById('displayTotal').textContent = formatRupiah(total);
                document.getElementById('displayPaid').textContent = formatRupiah(dibayar);
                document.getElementById('displayChange').textContent = formatRupiah(kembalian);
            }

            document.querySelectorAll('#total, #dibayar').forEach((input) => {
                input.addEventListener('input', updatePaymentSummary);
            });

            document.getElementById('resetPayment').addEventListener('click', () => {
                document.getElementById('total').value = 0;
                document.getElementById('dibayar').value = 0;
                document.getElementById('metode').value = '';
                document.getElementById('catatan').value = '';
                updatePaymentSummary();
            });

            updatePaymentSummary();
        </script>
    @endpush
@endsection
