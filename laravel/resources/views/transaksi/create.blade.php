@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Simpan Detail Transaksi</h1>
                <p class="mt-1 text-sm text-slate-600">Catat transaksi penjualan dengan multiple produk.</p>
            </div>
            <a href="{{ route('produks.index') }}" class="inline-flex items-center rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200">Kembali ke Produk</a>
        </div>

        @if(session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-900">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach>
                </ul>
            </div>
        @endif

        <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf

            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-slate-900">Detail Produk</h3>
                    <button type="button" id="addProduct" class="inline-flex items-center rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white hover:bg-sky-700">Tambah Produk</button>
                </div>

                <div id="productRows" class="space-y-4">
                    <div class="product-row grid gap-4 sm:grid-cols-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Produk</label>
                            <select name="produk_id[]" required class="mt-1 w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100">
                                <option value="">Pilih produk</option>
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id }}">{{ $produk->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Jumlah</label>
                            <input name="jumlah[]" type="number" min="1" required class="mt-1 w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100 product-quantity" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Harga Satuan</label>
                            <input name="harga_satuan[]" type="number" min="0" step="0.01" required class="mt-1 w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100 product-price" />
                        </div>
                        <div class="flex items-end">
                            <button type="button" class="remove-product inline-flex items-center rounded-md bg-rose-600 px-3 py-2 text-sm font-semibold text-white hover:bg-rose-700" style="display: none;">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-slate-700">Tanggal</label>
                    <input id="tanggal" name="tanggal" type="date" value="{{ date('Y-m-d') }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex items-center justify-between text-sm text-slate-600">
                    <span>Total Transaksi</span>
                    <span class="font-semibold text-slate-900" id="displayTotal">Rp 0</span>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white hover:bg-sky-700">Simpan Transaksi</button>
                <a href="{{ route('transaksi.create') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function formatRupiah(value) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value);
            }

            function updateTotal() {
                let total = 0;
                document.querySelectorAll('.product-row').forEach(row => {
                    const quantity = Number(row.querySelector('.product-quantity').value) || 0;
                    const price = Number(row.querySelector('.product-price').value) || 0;
                    total += quantity * price;
                });
                document.getElementById('displayTotal').textContent = formatRupiah(total);
            }

            function addProductRow() {
                const productRows = document.getElementById('productRows');
                const firstRow = productRows.querySelector('.product-row');
                const newRow = firstRow.cloneNode(true);

                // Reset values
                newRow.querySelector('select').value = '';
                newRow.querySelector('.product-quantity').value = '';
                newRow.querySelector('.product-price').value = '';

                // Show remove button
                newRow.querySelector('.remove-product').style.display = 'inline-flex';

                productRows.appendChild(newRow);
                updateTotal();
            }

            function removeProductRow(button) {
                const row = button.closest('.product-row');
                if (document.querySelectorAll('.product-row').length > 1) {
                    row.remove();
                    updateTotal();
                }
            }

            document.getElementById('addProduct').addEventListener('click', addProductRow);

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-product')) {
                    removeProductRow(e.target);
                }
            });

            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('product-quantity') || e.target.classList.contains('product-price')) {
                    updateTotal();
                }
            });

            updateTotal();
        </script>
    @endpush
@endsection