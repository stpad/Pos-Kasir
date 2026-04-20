<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
<<<<<<< HEAD
use Illuminate\Validation\ValidationException;
=======
>>>>>>> crud-user
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
<<<<<<< HEAD
    /**
     * Display the registration view.
     */
=======
>>>>>>> crud-user
    public function create(): View
    {
        return view('auth.register');
    }

<<<<<<< HEAD
    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
=======
>>>>>>> crud-user
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
<<<<<<< HEAD
=======
            'role' => ['required', 'in:admin,cashier'],
>>>>>>> crud-user
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
<<<<<<< HEAD
=======
            'role' => $request->role,
>>>>>>> crud-user
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> crud-user
