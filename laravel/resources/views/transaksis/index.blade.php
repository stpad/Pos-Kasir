@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi') }}
        </h2>
        <a href="{{ route('transaksis.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
            + Transaksi Baru
        </a>
    </div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Search Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <form method="GET" action="{{ route('transaksis.index') }}" class="flex gap-4">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $search ?? '' }}"
                            placeholder="Cari kode transaksi atau nama kasir..." 
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2"
                        >
                    </div>
                    <button 
                        type="submit"
                        class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-6 rounded-lg transition"
                    >
                        Cari
                    </button>
                    @if($search)
                        <a href="{{ route('transaksis.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Transactions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($transaksis as $transaksi)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $transaksi->kode_transaksi }}</h3>
                                <p class="text-sm text-gray-500">{{ $transaksi->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <span class="px-3 py-1 text-xs font-medium rounded-full 
                                {{ $transaksi->status === 'selesai' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($transaksi->status) }}
                            </span>
                        </div>

                        <!-- Details -->
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Kasir:</span>
                                <span class="font-medium text-gray-900">{{ $transaksi->user->name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Items:</span>
                                <span class="font-medium text-gray-900">{{ $transaksi->items->count() }} produk</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total:</span>
                                <span class="font-bold text-lg text-gray-900">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 pt-4 border-t border-gray-100">
                            <a href="{{ route('transaksis.show', $transaksi) }}" class="flex-1 text-center bg-blue-50 hover:bg-blue-100 text-blue-600 font-medium py-2 px-4 rounded-lg transition text-sm">
                                Detail
                            </a>
                            <form action="{{ route('transaksis.destroy', $transaksi) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus transaksi?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-medium py-2 px-4 rounded-lg transition text-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada transaksi</h3>
                            <p class="mt-1 text-sm text-gray-500">Belum ada transaksi yang tercatat.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $transaksis->links() }}
        </div>
    </div>
</div>
@endsection