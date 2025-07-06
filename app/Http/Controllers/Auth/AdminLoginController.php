<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class AdminLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // No middleware here - we'll handle this in the routes
    }
    
    /**
     * Log the admin out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }

    /**
     * Show the admin login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // If user is already logged in as admin, redirect to admin dashboard
        if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super-admin'))) {
            return redirect()->route('admin.dashboard');
        }
        
        // If user is logged in but not an admin, log them out
        if (Auth::check()) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            
            return redirect()->route('admin.login')
                ->with('error', 'You do not have permission to access the admin area. Please log in with an admin account.');
        }
        
        return view('auth.admin-login');
    }

    /**
     * Handle an admin login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->only('email', 'remember'));
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        try {
            if (Auth::attempt($credentials, $remember)) {
                $user = Auth::user();
                
                // Check if user has admin role
                if ($user->hasRole('admin')) {
                    $request->session()->regenerate();
                    return redirect()->intended(route('admin.dashboard'));
                } else {
                    // User doesn't have admin role, log them out
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    
                    return back()->with('error', 'You do not have permission to access the admin area.');
                }
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email', 'remember'));
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database connection errors
            \Log::error('Database error during admin login: ' . $e->getMessage());
            return back()->withInput($request->only('email', 'remember'))
                ->with('warning', 'Login is currently unavailable due to database connection issues. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('Error during admin login: ' . $e->getMessage());
            return back()->withInput($request->only('email', 'remember'))
                ->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
