<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class OtpPasswordResetController extends Controller
{
    protected $smsService;

    /**
     * Create a new controller instance.
     *
     * @param SmsService $smsService
     */
    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Show the form to request a password reset via OTP.
     *
     * @return \Illuminate\View\View
     */
    public function showRequestForm()
    {
        return view('auth.passwords.otp-request');
    }

    /**
     * Show the form to verify OTP and reset password.
     *
     * @return \Illuminate\View\View
     */
    public function showResetForm()
    {
        if (!Session::has('reset_phone')) {
            return redirect()->route('password.otp.request')
                ->with('error', 'Please request an OTP first.');
        }

        return view('auth.passwords.otp-reset');
    }

    /**
     * Send OTP for password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|string|min:10|max:15',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Check if user exists with this phone number
            $user = User::where('phone', $request->phone)->first();

            if (!$user) {
                return back()->withInput()
                    ->with('error', 'No account found with this phone number.');
            }

            // Generate OTP
            $otp = Otp::generateForPhone($request->phone, 'password_reset');

            // Send OTP via SMS
            $result = $this->smsService->sendOtp($request->phone, $otp->otp);

            if ($result['success']) {
                // Store phone in session for next step
                Session::put('reset_phone', $request->phone);
                
                return redirect()->route('password.otp.verify')
                    ->with('success', 'OTP sent successfully to your phone number.');
            } else {
                return back()->withInput()
                    ->with('error', 'Failed to send OTP. ' . $result['message']);
            }
        } catch (\Exception $e) {
            Log::error('Error sending password reset OTP: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    /**
     * Verify OTP and reset password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp' => 'required|string|min:6|max:6',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator);
            }

            $phone = Session::get('reset_phone');

            if (!$phone) {
                return redirect()->route('password.otp.request')
                    ->with('error', 'Password reset session expired. Please try again.');
            }

            // Verify OTP
            $otpVerified = Otp::verifyPhoneOtp($phone, $request->otp, 'password_reset');

            if (!$otpVerified) {
                return back()
                    ->with('error', 'Invalid OTP or OTP has expired. Please try again.');
            }

            // Find user and reset password
            $user = User::where('phone', $phone)->first();

            if (!$user) {
                return redirect()->route('password.otp.request')
                    ->with('error', 'User not found. Please try again.');
            }

            $user->password = Hash::make($request->password);
            $user->save();

            // Clear session data
            Session::forget('reset_phone');

            return redirect()->route('login')
                ->with('success', 'Your password has been reset successfully. You can now log in with your new password.');
        } catch (\Exception $e) {
            Log::error('Error resetting password via OTP: ' . $e->getMessage());
            return back()
                ->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    /**
     * Resend OTP for password reset.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendOtp()
    {
        try {
            $phone = Session::get('reset_phone');

            if (!$phone) {
                return redirect()->route('password.otp.request')
                    ->with('error', 'Password reset session expired. Please try again.');
            }

            // Generate new OTP
            $otp = Otp::generateForPhone($phone, 'password_reset');

            // Send OTP via SMS
            $result = $this->smsService->sendOtp($phone, $otp->otp);

            if ($result['success']) {
                return back()
                    ->with('success', 'OTP resent successfully to your phone number.');
            } else {
                return back()
                    ->with('error', 'Failed to resend OTP. ' . $result['message']);
            }
        } catch (\Exception $e) {
            Log::error('Error resending password reset OTP: ' . $e->getMessage());
            return back()
                ->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
