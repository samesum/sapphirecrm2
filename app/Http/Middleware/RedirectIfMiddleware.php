<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class RedirectIfMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(DB::connection()->getDatabaseName() != 'db_name') {
            if (Auth::check() && Auth::user()) {
                $role = Role::where('id', Auth::user()->role_id)->value('title');
                return redirect()->route($role . '.dashboard');
            }
            return $next($request);
        } else {
            return redirect('/install');
        }
    }
}
