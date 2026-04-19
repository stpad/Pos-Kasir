@extends('auth.layout')

@section('content')
<div class="text-sm text-gray-600">
    This is a secure area of the application. Please confirm your password before continuing.
</div>

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input id="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" name="password" required autocomplete="current-password">
        @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end mt-4">
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Confirm
        </button>
    </div>
</form>
@endsection