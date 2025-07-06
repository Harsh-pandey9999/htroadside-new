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

class OtpVerificationController extends Controller
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
     * Show the OTP verification form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showVerificationForm()
    {
        // Check if registration data exists in session
        if (!Session::has('registration_data')) {
            return redirect()->route('register')
                ->with('error', 'Please complete the registration form first.');
        }

        return view('auth.verify-otp');
    }

    /**
     * Send OTP to the user's phone.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|min:10|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid phone number',
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate OTP
        $otp = Otp::generateForPhone($request->phone);

        // Send OTP via SMS
        $result = $this->smsService->sendOtp($request->phone, $otp->otp);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully to your phone number.',
                'token' => $otp->token
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. ' . $result['message']
            ], 500);
        }
    }

    /**
     * Verify OTP and complete registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|string|min:6|max:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get registration data from session
        $registrationData = Session::get('registration_data');

        if (!$registrationData) {
            return redirect()->route('register')
                ->with('error', 'Registration data not found. Please try again.');
        }

        // Verify OTP
        $otpVerified = Otp::verifyPhoneOtp($registrationData['phone'], $request->otp);

        if (!$otpVerified) {
            return redirect()->back()
                ->with('error', 'Invalid OTP or OTP has expired. Please try again.');
        }

        // Create the user
        $user = User::create([
            'name' => $registrationData['name'],
            'email' => $registrationData['email'],
            'phone' => $registrationData['phone'],
            'password' => Hash::make($registrationData['password']),
            'phone_verified_at' => now(),
        ]);

        // Clear registration data from session
        Session::forget('registration_data');

        // Log the user in
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Registration completed successfully!');
    }

    /**
     * Resend OTP.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resendOtp(Request $request)
    {
        // Get registration data from session
        $registrationData = Session::get('registration_data');

        if (!$registrationData) {
            return response()->json([
                'success' => false,
                'message' => 'Registration data not found. Please try again.'
            ], 400);
        }

        // Generate new OTP
        $otp = Otp::generateForPhone($registrationData['phone']);

        // Send OTP via SMS
        $result = $this->smsService->sendOtp($registrationData['phone'], $otp->otp);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'OTP resent successfully to your phone number.',
                'token' => $otp->token
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to resend OTP. ' . $result['message']
            ], 500);
        }
    }

    /**
     * Verify OTP for password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyPasswordResetOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|min:10|max:15',
            'otp' => 'required|string|min:6|max:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify OTP
        $otpVerified = Otp::verifyPhoneOtp($request->phone, $request->otp, 'password_reset');

        if (!$otpVerified) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP or OTP has expired. Please try again.'
            ], 400);
        }

        // Store token in session for password reset
        Session::put('password_reset_token', $otpVerified->token);

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully.',
            'token' => $otpVerified->token
        ]);
    }

    /**
     * Send OTP for password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendPasswordResetOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|min:10|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid phone number',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if user exists with this phone number
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with this phone number.'
            ], 404);
        }

        // Generate OTP
        $otp = Otp::generateForPhone($request->phone, 'password_reset');

        // Send OTP via SMS
        $result = $this->smsService->sendOtp($request->phone, $otp->otp);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully to your phone number.',
                'token' => $otp->token
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. ' . $result['message']
            ], 500);
        }
    }
}
