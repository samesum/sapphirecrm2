<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = Role::where('id', Auth::user()->role_id)->first();
        if ($role->title != 'staff') {
            return redirect()->route($role->title.'.dashboard')->with('error', get_phrase('You are not authorized to access this page'));
        }
        return $next($request);
    }
}
