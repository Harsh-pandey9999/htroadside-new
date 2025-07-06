<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Database\QueryException;

class ForgotPasswordController extends Controller
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
            ]);
    
            // Attempt to send the password reset link
            $status = Password::sendResetLink(
                $request->only('email')
            );
    
            return $status === Password::RESET_LINK_SENT
                        ? back()->with('status', __($status))
                        : back()->withErrors(['email' => __($status)]);
        } catch (QueryException $e) {
            \Log::error('Database error during password reset request: ' . $e->getMessage());
            return back()->withInput($request->only('email'))
                ->with('warning', 'Password reset is currently unavailable due to database connection issues. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('Error during password reset request: ' . $e->getMessage());
            return back()->withInput($request->only('email'))
                ->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
