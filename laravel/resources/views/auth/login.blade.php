@extends('auth.layout')

@section('content')
@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input id="password" type="password" name="password" required autocomplete="current-password"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="block mb-4">
        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
            <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </label>
    </div>

    <div class="flex items-center justify-between mt-4">
        @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                Forgot your password?
            </a>
        @endif

        <button type="submit" class="ml-3 px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-md">
            Log in
        </button>
    </div>
</form>
@endsection

