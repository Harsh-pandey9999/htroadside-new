<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Otp;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;

class RegisterController extends Controller
{
    /**
     * The SMS service instance.
     *
     * @var \App\Services\SmsService
     */
    protected $smsService;
    
    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\SmsService  $smsService
     * @return void
     */
    public function __construct(SmsService $smsService)
    {
        $this->middleware('guest');
        $this->smsService = $smsService;
    }
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'max:20'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'terms' => ['required', 'accepted'],
            ]);
            
            // Store registration data in session
            Session::put('registration_data', [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
            ]);
            
            // Generate and send OTP
            $otp = Otp::generateForPhone($request->phone, 'user_registration');
            $result = $this->smsService->sendOtp($request->phone, $otp->otp);
            
            if (!$result['success']) {
                \Log::error('Failed to send OTP during user registration: ' . json_encode($result));
                return back()->withInput($request->except('password', 'password_confirmation'))
                    ->with('error', 'Failed to send verification code. Please try again.');
            }
            
            // Redirect to OTP verification page
            return redirect()->route('user.verify.otp')
                ->with('success', 'A verification code has been sent to your phone number.');
                
        } catch (QueryException $e) {
            \Log::error('Database error during registration: ' . $e->getMessage());
            return back()->withInput($request->except('password', 'password_confirmation'))
                ->with('warning', 'Registration is currently unavailable due to database connection issues. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('Error during registration: ' . $e->getMessage());
            return back()->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
    
    /**
     * Show the OTP verification form.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showOtpVerificationForm()
    {
        if (!Session::has('registration_data')) {
            return redirect()->route('register')
                ->with('error', 'Registration session expired. Please start again.');
        }
        
        $phone = Session::get('registration_data.phone');
        return view('auth.user-verify-otp', compact('phone'));
    }
    
    /**
     * Verify the OTP and complete registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'otp' => ['required', 'string', 'size:6'],
            ]);
            
            if (!Session::has('registration_data')) {
                return redirect()->route('register')
                    ->with('error', 'Registration session expired. Please start again.');
            }
            
            $registrationData = Session::get('registration_data');
            $phone = $registrationData['phone'];
            
            // Verify OTP
            $verified = Otp::verifyOtp($phone, $request->otp, 'user_registration');
            
            if (!$verified) {
                return back()->with('error', 'Invalid verification code. Please try again.');
            }
            
            // Create user after OTP verification
            $user = User::create([
                'name' => $registrationData['name'],
                'email' => $registrationData['email'],
                'phone' => $phone,
                'password' => Hash::make($registrationData['password']),
                'phone_verified_at' => now(),
            ]);
            
            // Assign customer role
            try {
                $customerRole = Role::where('name', 'customer')->first();
                if ($customerRole) {
                    $user->roles()->attach($customerRole);
                } else {
                    \Log::warning('Customer role not found during user registration');
                }
            } catch (QueryException $e) {
                \Log::error('Error assigning role during registration: ' . $e->getMessage());
            }
            
            // Clear registration data from session
            Session::forget('registration_data');
            
            event(new Registered($user));
            
            Auth::login($user);
            
            return redirect()->route('customer.dashboard')
                ->with('success', 'Registration completed successfully!');
                
        } catch (QueryException $e) {
            \Log::error('Database error during OTP verification: ' . $e->getMessage());
            return back()->with('warning', 'Verification is currently unavailable due to database connection issues. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('Error during OTP verification: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
    
    /**
     * Resend OTP for verification.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendOtp()
    {
        try {
            if (!Session::has('registration_data')) {
                return redirect()->route('register')
                    ->with('error', 'Registration session expired. Please start again.');
            }
            
            $phone = Session::get('registration_data.phone');
            
            // Generate and send new OTP
            $otp = Otp::generateForPhone($phone, 'user_registration');
            $result = $this->smsService->sendOtp($phone, $otp->otp);
            
            if (!$result['success']) {
                \Log::error('Failed to resend OTP during user registration: ' . json_encode($result));
                return back()->with('error', 'Failed to send verification code. Please try again.');
            }
            
            return back()->with('success', 'A new verification code has been sent to your phone number.');
            
        } catch (\Exception $e) {
            \Log::error('Error resending OTP: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
