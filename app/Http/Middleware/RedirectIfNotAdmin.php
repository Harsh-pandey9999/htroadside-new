<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // If not logged in, redirect to admin login
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }
        
        // If logged in but not an admin, log them out and redirect to admin login
        if (!Auth::user()->hasRole('admin')) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login')
                ->with('error', 'You do not have permission to access the admin area.');
        }

        return $next($request);
    }
}
