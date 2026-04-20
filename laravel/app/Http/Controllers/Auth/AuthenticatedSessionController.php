<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Http\Requests\Auth\LoginRequest;
=======
>>>>>>> crud-user
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
<<<<<<< HEAD
    /**
     * Display the login view.
     */
=======
>>>>>>> crud-user
    public function create(): View
    {
        return view('auth.login');
    }

<<<<<<< HEAD
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect berdasarkan role user
        $user = $request->user();
        
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
        
        return redirect()->intended(route('cashier.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
=======
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard', absolute: false));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

>>>>>>> crud-user
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
<<<<<<< HEAD

=======
>>>>>>> crud-user
        $request->session()->regenerateToken();

        return redirect('/');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> crud-user
