<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            // Store the intended URL to redirect back after login
            session(['url.intended' => url()->current()]);
            return redirect()->route('login'); // Redirect to the login page
        }

        return $next($request); // User is authenticated, continue with the request
    }
}
