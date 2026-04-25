@extends('auth.layout')

@section('content')
<div class="min-h-screen bg-cover bg-center bg-no-repeat relative"
    style="background-image: url('{{ asset('images/minimarket-bg.jpg') }}');">

    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black/30"></div>

    {{-- Login Card --}}
    <div class="relative z-10 min-h-screen flex items-center justify-end px-6 lg:px-20">
        <div class="w-full max-w-md">
            <div class="bg-white/95 backdrop-blur-md shadow-2xl rounded-3xl p-8 lg:p-10">

                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Selamat Datang
                    </h1>
                    <p class="text-gray-600 mt-2">
                        Login ke sistem minimarket Anda
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-4 p-4 rounded-2xl bg-green-50 text-green-700 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <input id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-3">

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <input id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-3">

                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember --}}
                    <div class="flex items-center mb-6">
                        <input id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">

                        <label for="remember_me" class="ml-2 text-sm text-gray-600">
                            Remember me
                        </label>
                    </div>

                    {{-- Action --}}
                    <div class="space-y-4">
                        <button type="submit"
                            class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-2xl transition duration-300 shadow-lg">
                            Log In
                        </button>

                        @if (Route::has('password.request'))
                            <div class="text-center">
                                <a href="{{ route('password.request') }}"
                                    class="text-sm text-indigo-600 hover:text-indigo-800">
                                    Forgot your password?
                                </a>
                            </div>
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection