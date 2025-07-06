<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Otp;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
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
        // Don't call middleware directly on the controller
        // It should be defined in the routes or in a parent constructor
        $this->smsService = $smsService;
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login-material');
    }
    
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $loginType = $request->input('login_type', 'customer');
        
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        try {
            // Log the login attempt for debugging
            \Log::info('Login attempt', [
                'email' => $request->email,
                'login_type' => $loginType,
                'remember' => $request->filled('remember')
            ]);
            
            // For testing purposes, create a test user if none exists
            $testUser = \App\Models\User::where('email', 'test@example.com')->first();
            if (!$testUser) {
                $testUser = new \App\Models\User();
                $testUser->name = 'Test User';
                $testUser->email = 'test@example.com';
                $testUser->password = bcrypt('password');
                $testUser->save();
                $testUser->assignRole('customer');
                \Log::info('Created test user for login testing');
            }
            
            // Try to authenticate the user
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
                $request->session()->regenerate();
                $user = Auth::user();
                
                \Log::info('User authenticated', ['user_id' => $user->id, 'roles' => $user->getRoleNames()]);
                
                if ($loginType === 'vendor' && !$user->hasRole('service-provider')) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    
                    \Log::warning('User attempted to login as vendor but lacks service-provider role');
                    
                    return back()->withInput($request->only('email', 'remember'))
                        ->with('error', 'These credentials do not match our records for a service provider account.');
                }
                
                if ($loginType === 'customer' && $user->hasRole('service-provider') && !$user->hasRole('customer')) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    
                    \Log::warning('Service provider attempted to login as customer');
                    
                    return back()->withInput($request->only('email', 'remember'))
                        ->with('error', 'Please use the Service Provider login tab to access your account.');
                }
                
                // Set the design version to material
                session(['design_version' => 'material']);
                
                if ($user->hasRole('admin')) {
                    return redirect()->intended(route('admin.dashboard'));
                } elseif ($user->hasRole('service-provider')) {
                    return redirect()->intended(route('provider.dashboard'));
                } else {
                    return redirect()->intended(route('customer.dashboard'));
                }
            }
            
            \Log::warning('Failed login attempt', ['email' => $request->email]);
            
            // For debugging, check if the user exists
            $user = \App\Models\User::where('email', $request->email)->first();
            if ($user) {
                \Log::info('User exists but password does not match', ['user_id' => $user->id]);
            } else {
                \Log::info('User does not exist with this email');
            }
            
            return back()->withInput($request->only('email', 'remember'))
                ->with('error', 'A database error occurred. Please try again later.');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Login error: ' . $e->getMessage());
            
            return back()->withInput($request->only('email', 'remember'))
                ->with('error', 'An error occurred during login. Please try again.');
        }
    }
    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
    
    /**
     * Show the OTP login form.
     *
     * @return \Illuminate\View\View
     */
    public function showOtpLoginForm()
    {
        return view('auth.otp-login');
    }
    
    /**
     * Send OTP for login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendLoginOtp(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required|string|exists:users,phone',
            ]);
            
            $phone = $request->phone;
            
            try {
                // Generate and send OTP
                $otp = Otp::generate($phone, 'login');
                $smsService = new SmsService();
                $message = "Your OTP for login is: {$otp}. Valid for 5 minutes.";
                $smsService->send($phone, $message);
                
                // Store phone in session for verification with expiration time (5 minutes)
                Session::put('otp_login_phone', $phone);
                Session::put('otp_login_expires_at', now()->addMinutes(5)->timestamp);
                
                return redirect()->route('login.otp.verify')
                    ->with('success', 'OTP has been sent to your phone.');
            } catch (\Illuminate\Database\QueryException $e) {
                \Log::error('Database error during OTP send: ' . $e->getMessage());
                
                if (str_contains($e->getMessage(), 'Access denied')) {
                    return back()->withInput($request->only('phone'))
                        ->with('error', 'Database connection issue. Please contact support with error code: DB-OTP-001.');
                }
                
                return back()->withInput($request->only('phone'))
                    ->with('error', 'Failed to send OTP. Please try again later.');
            }
        } catch (\Exception $e) {
            Log::error('Error during OTP login: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
    
    /**
     * Show the OTP verification form for login.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showOtpVerificationForm()
    {
        if (!Session::has('otp_login_phone')) {
            return redirect()->route('login.otp')
                ->with('error', 'Please enter your phone number first.');
        }
        
        // Check if OTP session has expired
        if (Session::has('otp_login_expires_at')) {
            $expiresAt = Session::get('otp_login_expires_at');
            if (now()->timestamp > $expiresAt) {
                // Clear expired session data
                Session::forget(['otp_login_phone', 'otp_login_expires_at']);
                return redirect()->route('login.otp')
                    ->with('error', 'Verification session has expired. Please request a new OTP.');
            }
        }
        
        $phone = Session::get('otp_login_phone');
        // Calculate remaining time for display
        $remainingSeconds = 0;
        if (Session::has('otp_login_expires_at')) {
            $expiresAt = Session::get('otp_login_expires_at');
            $remainingSeconds = max(0, $expiresAt - now()->timestamp);
        }
        
        return view('auth.otp-login-verify', compact('phone', 'remainingSeconds'));
    }
    
    /**
     * Verify OTP and login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyLoginOtp(Request $request)
    {
        try {
            $request->validate([
                'otp' => 'required|string|size:6',
            ]);
            
            if (!Session::has('otp_login_phone')) {
                return redirect()->route('login.otp')
                    ->with('error', 'Please enter your phone number first.');
            }
            
            // Check if OTP session has expired
            if (Session::has('otp_login_expires_at')) {
                $expiresAt = Session::get('otp_login_expires_at');
                if (now()->timestamp > $expiresAt) {
                    // Clear expired session data
                    Session::forget(['otp_login_phone', 'otp_login_expires_at']);
                    return redirect()->route('login.otp')
                        ->with('error', 'Verification session has expired. Please request a new OTP.');
                }
            }
            
            $phone = Session::get('otp_login_phone');
            
            // Verify OTP
            $verified = Otp::verifyOtp($phone, $request->otp, 'login');
            
            if (!$verified) {
                return back()->with('error', 'Invalid verification code. Please try again.');
            }
            
            try {
                // Find user by phone
                $user = User::where('phone', $phone)->first();
                
                if (!$user) {
                    return redirect()->route('login.otp')
                        ->with('error', 'No account found with this phone number.');
                }
                
                // Login user
                Auth::login($user, $request->filled('remember'));
                
                // Clear session data
                Session::forget(['otp_login_phone', 'otp_login_expires_at']);
                
                // Check user role and redirect accordingly
                if ($user->hasRole('admin')) {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->hasRole('service-provider')) {
                    return redirect()->route('provider.dashboard');
                } else {
                    return redirect()->route('customer.dashboard');
                }
                
            } catch (QueryException $e) {
                Log::error('Database error during OTP login verification: ' . $e->getMessage());
                
                // Check if it's a MySQL access denied error
                if (str_contains($e->getMessage(), 'Access denied')) {
                    return back()->with('error', 'Database connection issue. Please contact support with error code: DB-OTP-001.');
                }
                
                return back()->with('warning', 'Login is currently unavailable due to database connection issues. Please try again later.');
            }
        } catch (\Exception $e) {
            Log::error('Error during OTP login verification: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
    
    /**
     * Resend OTP for login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendLoginOtp()
    {
        try {
            if (!Session::has('otp_login_phone')) {
                return redirect()->route('login.otp')
                    ->with('error', 'Please enter your phone number first.');
            }
            
            $phone = Session::get('otp_login_phone');
            
            // Generate and send new OTP
            try {
                $otp = Otp::generate($phone, 'login');
                $smsService = new SmsService();
                $message = "Your OTP for login is: {$otp}. Valid for 5 minutes.";
                $smsService->send($phone, $message);
                
                // Update expiration time (5 minutes)
                Session::put('otp_login_expires_at', now()->addMinutes(5)->timestamp);
                
                return back()->with('success', 'A new verification code has been sent to your phone number.');
            } catch (\Illuminate\Database\QueryException $e) {
                \Log::error('Database error during OTP resend: ' . $e->getMessage());
                
                if (str_contains($e->getMessage(), 'Access denied')) {
                    return back()->with('error', 'Database connection issue. Please contact support with error code: DB-OTP-002.');
                }
                
                return back()->with('error', 'Failed to resend OTP. Please try again later.');
            }
        } catch (\Exception $e) {
            Log::error('Error resending login OTP: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
