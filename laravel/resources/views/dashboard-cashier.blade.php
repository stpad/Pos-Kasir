<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">
                            Selamat Datang, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="text-gray-600 text-lg">
                            Siap melayani transaksi hari ini?
                        </p>
                    </div>

                    <div class="mt-8 flex justify-center">
                        <a href="{{ route('transaksis.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition">
                            Mulai Transaksi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>