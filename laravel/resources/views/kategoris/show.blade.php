<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label :value="__('Nama')" />
                            <div class="mt-1 text-sm text-gray-900">{{ $kategori->nama }}</div>
                        </div>

                        <div>
                            <x-input-label :value="__('Deskripsi')" />
                            <div class="mt-1 text-sm text-gray-900">{{ $kategori->deskripsi ?? '-' }}</div>
                        </div>

                        <div>
                            <x-input-label :value="__('Dibuat pada')" />
                            <div class="mt-1 text-sm text-gray-500">{{ $kategori->created_at->format('d M Y H:i') }}</div>
                        </div>

                        <div>
                            <x-input-label :value="__('Terakhir diperbarui')" />
                            <div class="mt-1 text-sm text-gray-500">{{ $kategori->updated_at->format('d M Y H:i') }}</div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-4">
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('kategoris.edit', $kategori) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Edit') }}
                        </a>
                        @endif
                        <a href="{{ route('kategoris.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Kembali') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>