<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="relative overflow-hidden bg-gradient-to-r from-green-500 via-emerald-500 to-teal-600 rounded-3xl shadow-2xl p-8 mb-8 text-white">
                <!-- Background Decoration -->
                <div class="absolute top-0 right-0 text-9xl opacity-10 transform rotate-12">
                    🚀
                </div>
                <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute top-6 right-24 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>

                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-extrabold mb-3">
                            Selamat Datang, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="text-lg text-green-100 max-w-2xl">
                            Siap melayani pelanggan hari ini? Semoga transaksi berjalan lancar,
                            cepat, dan tanpa kendala.
                        </p>
                    </div>

                    <div class="hidden lg:block text-8xl animate-bounce">
                        🚀
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl shadow-xl p-6 text-white">
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
        </div>
    </div>


</x-app-layout>
<script>
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
</script>


