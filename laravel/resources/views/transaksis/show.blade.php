@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaksi') }}
        </h2>
        <a href="{{ route('transaksis.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
            ← Kembali
        </a>
    </div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Transaction Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-start mb-6 pb-6 border-b border-gray-200">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $transaksi->kode_transaksi }}</h3>
                        <p class="text-gray-500 mt-1">{{ $transaksi->created_at->format('d F Y, H:i:s') }}</p>
                    </div>
                    <span class="px-4 py-2 text-sm font-medium rounded-full 
                        {{ $transaksi->status === 'selesai' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($transaksi->status) }}
                    </span>
                </div>

                <!-- Info -->
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <div class="text-sm text-gray-500">Kasir</div>
                        <div class="font-medium text-gray-900">{{ $transaksi->user->name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Total Items</div>
                        <div class="font-medium text-gray-900">{{ $transaksi->items->sum('jumlah') }} produk</div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Detail Items</h4>
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transaksi->items as $item)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->produk->nama }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-center">{{ $item->jumlah }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-right">Rp {{ number_format($item->harga_saat_transaksi, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Harga</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Jumlah Bayar</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-2 border-t border-gray-200">
                            <span>Kembalian</span>
                            <span class="text-green-600">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Print Button -->
                <div class="mt-6 flex gap-4">
                    <button onclick="window.print()" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white font-medium py-3 px-4 rounded-lg transition">
                        Cetak Struk
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection