<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    public function __construct()
    {
        $this->redirect();
    }

    function redirect() {
        if(DB::connection()->getDatabaseName() == 'db_name') {
            return redirect()->route('install');
        }
    }
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            $role = Role::where('id', Auth::user()->role_id)->value('title');

            Session::put('user_id', Auth::user()->role_id);

            return redirect()->intended(route($role . '.dashboard', [], false))
                ->with('success', 'Login successful!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Login failed! Please check your credentials.');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged Out successfully.');
    }
}
