<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'Pos Kasir') }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
        </style>
    @endif
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="min-h-screen bg-slate-50 text-slate-900">
        <header class="border-b border-slate-200 bg-white shadow-sm">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <div>
                    <a href="{{ route('kategoris.index') }}" class="text-lg font-semibold text-slate-900">Pos Kasir</a>
                </div>
                <nav class="flex items-center gap-3 text-sm text-slate-600">
                    <a href="{{ route('kategoris.index') }}" class="rounded-md px-3 py-2 hover:bg-slate-100">Kategori</a>
                    <a href="{{ route('produks.index') }}" class="rounded-md px-3 py-2 hover:bg-slate-100">Produk</a>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
