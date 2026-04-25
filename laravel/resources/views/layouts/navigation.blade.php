<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo (Left) -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
            </div>

            <!-- Navigation Links (Center) -->
            <div class="hidden sm:flex sm:items-center sm:justify-center flex-1">
                <div class="flex space-x-8">
                    @if (auth()->user()->role === 'cashier')
                        <x-nav-link :href="route('transaksis.create')" :active="request()->routeIs('transaksis.create')">
                            {{ __('Transaksi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('transaksis.index')" :active="request()->routeIs('transaksis.index')">
                            {{ __('Histori') }}
                        </x-nav-link>
                    @endif
                    @if (auth()->user()->role === 'admin')
                        <x-nav-link :href="route('kasirs.index')" :active="request()->routeIs('kasirs.*')">
                            {{ __('Kasir') }}
                        </x-nav-link>
                        <x-nav-link :href="route('kategoris.index')" :active="request()->routeIs('kategoris.*')">
                            {{ __('Kategori') }}
                        </x-nav-link>
                        <x-nav-link :href="route('produks.index')" :active="request()->routeIs('produks.*')">
                            {{ __('Produk') }}
                            <x-nav-link :href="route('transaksis.index')" :active="request()->routeIs('transaksis.index')">
                                {{ __('Histori Penjualan') }}
                            </x-nav-link>
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown (Right) -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <!-- User Role -->
                        <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                            <div class="text-xs text-gray-500 dark:text-gray-400">Role:</div>
                            <div class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                {{ ucfirst(auth()->user()->role) }}
                            </div>
                        </div>

                        <!-- Dark Mode Toggle -->
                        <button id="theme-toggle" type="button"
                            class="w-full flex items-center justify-between px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <span>🌙 Dark Mode</span>

                            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707
                     8.001 8.001 0 1017.293 13.293z" />
                            </svg>

                            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm0 12
                     a4 4 0 100-8 4 4 0 000 8zm7-5a1 1 0 100-2h-1
                     a1 1 0 100 2h1zM4 10a1 1 0 100-2H3
                     a1 1 0 100 2h1z" />
                            </svg>
                        </button>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            @if (auth()->user()->role === 'cashier')
                <x-responsive-nav-link :href="route('transaksis.create')" :active="request()->routeIs('transaksis.create')">
                    {{ __('Transaksi') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('transaksis.index')" :active="request()->routeIs('transaksis.index')">
                    {{ __('Histori') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('kasirs.index')" :active="request()->routeIs('kasirs.*')">
                    {{ __('Kasir') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('kategoris.index')" :active="request()->routeIs('kategoris.*')">
                    {{ __('Kategori') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('produks.index')" :active="request()->routeIs('produks.*')">
                    {{ __('Produk') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('transaksis.index')" :active="request()->routeIs('transaksis.index')">
                    {{ __('Histori Penjualan') }}
                </x-responsive-nav-link>
            @endif

        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-100">
                    {{ Auth::user()->name }}
                </div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">
                    {{ Auth::user()->email }}
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Role: {{ ucfirst(auth()->user()->role) }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        function setTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                darkIcon.classList.add('hidden');
                lightIcon.classList.remove('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            }
        }

        const savedTheme = localStorage.getItem('theme') || 'light';
        setTheme(savedTheme);

        themeToggleBtn?.addEventListener('click', function() {
            const isDark = document.documentElement.classList.contains('dark');
            const newTheme = isDark ? 'light' : 'dark';

            localStorage.setItem('theme', newTheme);
            setTheme(newTheme);
        });
    });
</script>
