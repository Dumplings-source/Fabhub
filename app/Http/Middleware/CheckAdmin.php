<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'Admin') {
            return $next($request);
        }

        if (Auth::check()) {
            // Redirect non-admin users (e.g., customers) to dashboard
            return redirect()->route('dashboard')->with('error', 'You do not have admin access.');
        }

        // Redirect unauthenticated users to login
        return redirect()->route('login')->with('error', 'Please log in as an admin to access this page.');
    }
}