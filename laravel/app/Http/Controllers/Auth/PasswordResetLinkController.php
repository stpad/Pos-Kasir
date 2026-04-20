<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
<<<<<<< HEAD
use Illuminate\Validation\ValidationException;
=======
>>>>>>> crud-user
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
<<<<<<< HEAD
    /**
     * Display the password reset link request view.
     */
=======
>>>>>>> crud-user
    public function create(): View
    {
        return view('auth.forgot-password');
    }

<<<<<<< HEAD
    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
=======
>>>>>>> crud-user
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

<<<<<<< HEAD
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
=======
>>>>>>> crud-user
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
<<<<<<< HEAD
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
=======
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
    }
}
>>>>>>> crud-user
