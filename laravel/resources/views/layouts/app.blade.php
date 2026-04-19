<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased">
    <nav class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <div class="flex flex-shrink-0 items-center">
                        <a href="{{ route('produks.index') }}" class="text-xl font-bold text-slate-900">POS Kasir</a>
                    </div>
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <a href="{{ route('produks.index') }}" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-slate-500 hover:border-slate-300 hover:text-slate-700 {{ request()->routeIs('produks.*') ? 'border-sky-400 text-slate-900' : '' }}">Produk</a>
                        <a href="{{ route('kategoris.index') }}" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-slate-500 hover:border-slate-300 hover:text-slate-700 {{ request()->routeIs('kategoris.*') ? 'border-sky-400 text-slate-900' : '' }}">Kategori</a>
                        <a href="{{ route('transaksi.create') }}" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-slate-500 hover:border-slate-300 hover:text-slate-700 {{ request()->routeIs('transaksi.*') ? 'border-sky-400 text-slate-900' : '' }}">Transaksi</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>