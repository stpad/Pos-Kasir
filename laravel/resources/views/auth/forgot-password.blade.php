@extends('auth.layout')

@section('content')
<div class="mb-4 text-sm text-gray-600">
    Forgot your password? No problem. Just let us know your email address and we'll email you a password reset link that will allow you to choose a new one.
</div>

@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="block">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input id="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-end mt-4">
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Email Password Reset Link
        </button>
    </div>
</form>
@endsection