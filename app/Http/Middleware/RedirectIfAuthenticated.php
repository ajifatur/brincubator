<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && $request->user()->role_id == 0 && $request->path() == '/') {
            return redirect('/admin');
        }
        elseif (Auth::guard($guard)->check() && $request->user()->role_id == 1 && $request->path() == '/') {
            return redirect('/admin');
        }

        return $next($request);
    }
}
