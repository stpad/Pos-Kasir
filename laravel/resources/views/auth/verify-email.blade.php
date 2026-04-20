<<<<<<< HEAD
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
=======
@extends('layouts.app')

@section('content')
<div class="email-verification-container">
    <div class="mb-4 text-sm font-medium text-gray-600">
        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
>>>>>>> crud-user
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
<<<<<<< HEAD
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
=======
            A new verification link has been sent to the email address you provided during registration.
>>>>>>> crud-user
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
<<<<<<< HEAD

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
=======
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                Resend verification email
            </button>
>>>>>>> crud-user
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
<<<<<<< HEAD

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
=======
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                Log out
            </button>
        </form>
    </div>
</div>
@endsection
>>>>>>> crud-user
