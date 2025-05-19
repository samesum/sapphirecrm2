<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Smtp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Generate the password reset token
        $token = app('auth.password.broker')->createToken(
            User::where('email', $request->email)->first()
        );

        // Send the email
        $status = Smtp::send_mail('forget-password', $request->email, $token);

        return back()->with('status', __($status));
    }
}
