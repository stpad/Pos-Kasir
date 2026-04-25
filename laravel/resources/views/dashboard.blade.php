<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Warning Stok Rendah -->
            @if ($produkStokRendah->count() > 0)
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-yellow-800">
                                ⚠️ Ada {{ $produkStokRendah->count() }} produk dengan stok kurang dari 10!
                            </p>
                            <div class="mt-2 text-sm text-yellow-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($produkStokRendah as $produk)
                                        <li>
                                            <strong>{{ $produk->nama }}</strong> - Stok: <span
                                                class="font-bold text-red-600">{{ $produk->stok }}</span>
                                            <a href="{{ route('produks.edit', $produk) }}"
                                                class="ml-2 text-blue-600 hover:text-blue-800 underline">Edit</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div
                class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 overflow-hidden shadow-lg rounded-2xl">
                <div class="p-6 md:p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-bold mb-2">
                                👋 Selamat Datang, {{ Auth::user()->name }}!
                            </h2>
                            <p class="text-indigo-100 text-lg">
                                Semoga harimu menyenangkan dan penjualan hari ini lancar.
                            </p>
                        </div>

                        <div class="hidden md:block text-7xl animate-bounce">
                            🚀
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl shadow-xl p-6 text-white mt-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Waktu Saat Ini</p>
                        <h3 id="clock" class="text-4xl font-bold tracking-wider mt-2">
                            00:00:00
                        </h3>
                        <p id="date" class="text-blue-100 mt-2"></p>
                    </div>

                    <div class="hidden md:block">
                        <div class="text-6xl animate-pulse">🕒</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6 mt-6">
                <!-- Card Jumlah Produk -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">Jumlah Produk</dt>
                                <dd class="text-3xl font-semibold text-gray-900">{{ $jumlahProduk }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Jumlah Kategori -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-emerald-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">Jumlah Kategori</dt>
                                <dd class="text-3xl font-semibold text-gray-900">{{ $jumlahKategori }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2
                           3 .895 3 2-1.343 2-3 2m0-8V6m0 2v8m0 0v2" />
                                </svg>
                            </div>
                            <div class="ml-5 flex-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Penjualan Hari Ini
                                </dt>
                                <dd class="text-2xl font-bold text-gray-900">
                                    Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                           M9 5a2 2 0 002 2h2a2 2 0 002-2
                           M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-5 flex-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Total Transaksi
                                </dt>
                                <dd class="text-3xl font-bold text-gray-900">
                                    {{ number_format($totalTransaksi) }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">

                {{-- Card Stok Rendah --}}
                <div class="lg:col-span-8 flex">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 w-full h-full">
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">
                                        Peringatan Stok
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        Monitoring stok produk
                                    </p>
                                </div>

                                <div
                                    class="w-14 h-14 rounded-2xl flex items-center justify-center
            {{ $produkStokRendah->count() > 0 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                    @if ($produkStokRendah->count() > 0)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            @if ($produkStokRendah->count() > 0)
                                <div class="text-center py-6">
                                    <h4 class="text-4xl font-bold text-red-600 mb-2">
                                        {{ $produkStokRendah->count() }}
                                    </h4>
                                    <p class="text-gray-600 mb-6">
                                        Produk Memiliki Stok Rendah
                                    </p>

                                    <button
                                        onclick="document.getElementById('modalStokRendah').classList.remove('hidden')"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-2xl transition">
                                        Lihat Detail
                                    </button>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-10">
                                    <div
                                        class="w-24 h-24 rounded-full bg-green-50 flex items-center justify-center mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-green-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>

                                    <h4 class="text-lg font-semibold text-gray-800 mb-1">
                                        Stok Masih Aman
                                    </h4>

                                    <p class="text-sm text-gray-500 text-center">
                                        Semua produk memiliki stok yang mencukupi.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Chart Donut --}}
                <div class="lg:col-span-4 flex">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 w-full h-full flex flex-col">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-900">
                                Distribusi Kategori
                            </h3>
                            <p class="text-sm text-gray-500">
                                Jumlah produk per kategori
                            </p>
                        </div>

                        <div id="kategoriDonutChart" class="flex-1"></div>
                    </div>
                </div>

            </div>



            <div class="bg-white shadow-sm rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        Grafik Penjualan 7 Hari Terakhir
                    </h3>

                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Detail --}}
    @if ($produkStokRendah->count() > 0)
        <div id="modalStokRendah"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">

            <div class="bg-white rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b">
                    <h3 class="text-xl font-bold text-gray-900">
                        Produk Stok Rendah
                    </h3>

                    <button onclick="document.getElementById('modalStokRendah').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600 text-3xl leading-none">
                        &times;
                    </button>
                </div>

                <div class="p-6 overflow-y-auto max-h-[70vh]">
                    <div class="space-y-4">
                        @foreach ($produkStokRendah as $produk)
                            <div class="flex justify-between items-center p-4 border rounded-2xl">
                                <div>
                                    <h4 class="font-semibold text-gray-900">
                                        {{ $produk->nama }}
                                    </h4>
                                    <p class="text-sm text-gray-500">
                                        {{ $produk->kategori->nama ?? '-' }}
                                    </p>
                                </div>

                                <span class="px-4 py-2 bg-red-100 text-red-700 rounded-xl font-bold">
                                    {{ $produk->stok }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif


    </div>

    {{-- Modal Detail --}}
    @if ($produkStokRendah->count() > 0)
        <div id="modalStokRendah"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">

            <div class="bg-white rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b">
                    <h3 class="text-xl font-bold text-gray-900">
                        Produk Stok Rendah
                    </h3>

                    <button onclick="document.getElementById('modalStokRendah').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600 text-3xl leading-none">
                        &times;
                    </button>
                </div>

                <div class="p-6 overflow-y-auto max-h-[70vh]">
                    <div class="space-y-4">
                        @foreach ($produkStokRendah as $produk)
                            <div class="flex justify-between items-center p-4 border rounded-2xl">
                                <div>
                                    <h4 class="font-semibold text-gray-900">
                                        {{ $produk->nama }}
                                    </h4>
                                    <p class="text-sm text-gray-500">
                                        {{ $produk->kategori->nama ?? '-' }}
                                    </p>
                                </div>

                                <span class="px-4 py-2 bg-red-100 text-red-700 rounded-xl font-bold">
                                    {{ $produk->stok }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($grafikPenjualan->pluck('tanggal'));
        const data = @json($grafikPenjualan->pluck('total'));

        const ctx = document.getElementById('salesChart').getContext('2d');

        function updateClock() {
            const now = new Date();

            const time = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            const date = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            document.getElementById('clock').textContent = time;
            document.getElementById('date').textContent = date;
        }

        updateClock();
        setInterval(updateClock, 1000);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Penjualan',
                    data: data,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const options = {
                chart: {
                    type: 'donut',
                    height: 320
                },
                series: @json($kategoriChart->pluck('produks_count')),
                labels: @json($kategoriChart->pluck('nama')),
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%'
                        }
                    }
                },
                responsive: [{
                    breakpoint: 640,
                    options: {
                        chart: {
                            height: 280
                        }
                    }
                }]
            };

            const chart = new ApexCharts(
                document.querySelector("#kategoriDonutChart"),
                options
            );

            chart.render();
        });
    </script>
</x-app-layout>
