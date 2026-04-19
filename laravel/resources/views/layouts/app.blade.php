<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'POS Kasir') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-900">
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="/" class="text-lg font-semibold text-gray-900">{{ config('app.name', 'POS Kasir') }}</a>
            <div class="flex items-center gap-4 text-sm text-gray-600">
                <a href="{{ route('kategoris.index') }}" class="hover:text-gray-900">Kategoris</a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
