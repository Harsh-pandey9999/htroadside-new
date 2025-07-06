<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Service;
use App\Models\Otp;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class VendorRegisterController extends Controller
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
     * Show the vendor registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        try {
            $services = Service::all();
            return view('auth.vendor-register', compact('services'));
        } catch (QueryException $e) {
            \Log::error('Database error loading vendor registration form: ' . $e->getMessage());
            return view('auth.vendor-register')->with('warning', 'Some service options may not be available due to database connection issues.');
        }
    }

    /**
     * Handle a vendor registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'max:20'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'company_name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:100'],
                'state' => ['required', 'string', 'max:100'],
                'postal_code' => ['required', 'string', 'max:20'],
                'country' => ['required', 'string', 'max:100'],
                'service_area' => ['required', 'string', 'max:255'],
                'service_types' => ['required', 'array', 'min:1'],
                'bio' => ['required', 'string', 'max:1000'],
                'terms' => ['required', 'accepted'],
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            
            // Store registration data in session for OTP verification
            Session::put('vendor_registration_data', [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
                'company_name' => $request->company_name,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'service_area' => $request->service_area,
                'service_types' => $request->service_types,
                'bio' => $request->bio,
                'is_service_provider' => true,
            ]);
            
            // Generate and send OTP
            $otp = Otp::generateForPhone($request->phone, 'vendor_registration');
            $result = $this->smsService->sendOtp($request->phone, $otp->otp);
            
            if (!$result['success']) {
                Log::error('Failed to send OTP during vendor registration: ' . $result['message']);
                return back()->withInput($request->except('password', 'password_confirmation'))
                    ->with('error', 'Failed to send verification OTP. Please try again later.');
            }
            
            return redirect()->route('vendor.verify.otp')
                ->with('success', 'Please verify your phone number with the OTP sent to ' . $request->phone);
        } catch (QueryException $e) {
            \Log::error('Database error during vendor registration: ' . $e->getMessage());
            return back()->withInput($request->except('password', 'password_confirmation'))
                ->with('warning', 'Registration is currently unavailable due to database connection issues. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('Error during vendor registration: ' . $e->getMessage());
            return back()->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
    
    /**
     * Show the OTP verification form for vendor registration.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showOtpVerificationForm()
    {
        if (!Session::has('vendor_registration_data')) {
            return redirect()->route('vendor.register')
                ->with('error', 'Please complete the registration form first.');
        }
        
        return view('auth.vendor-verify-otp');
    }
    
    /**
     * Verify OTP and complete vendor registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp' => 'required|string|min:6|max:6',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator);
            }

            // Get registration data from session
            $registrationData = Session::get('vendor_registration_data');

            if (!$registrationData) {
                return redirect()->route('vendor.register')
                    ->with('error', 'Registration data not found. Please try again.');
            }

            // Verify OTP
            $otpVerified = Otp::verifyPhoneOtp($registrationData['phone'], $request->otp, 'vendor_registration');

            if (!$otpVerified) {
                return back()
                    ->with('error', 'Invalid OTP or OTP has expired. Please try again.');
            }

            // Create the vendor user
            $user = User::create([
                'name' => $registrationData['name'],
                'email' => $registrationData['email'],
                'phone' => $registrationData['phone'],
                'password' => Hash::make($registrationData['password']),
                'company_name' => $registrationData['company_name'],
                'address' => $registrationData['address'],
                'city' => $registrationData['city'],
                'state' => $registrationData['state'],
                'postal_code' => $registrationData['postal_code'],
                'country' => $registrationData['country'],
                'service_area' => $registrationData['service_area'],
                'service_types' => $registrationData['service_types'],
                'bio' => $registrationData['bio'],
                'is_service_provider' => true,
                'phone_verified_at' => now(),
            ]);
            
            // Assign service provider role
            try {
                $vendorRole = Role::where('slug', 'service-provider')->first();
                if ($vendorRole) {
                    $user->roles()->attach($vendorRole);
                } else {
                    \Log::warning('Service provider role not found during vendor registration');
                }
            } catch (QueryException $e) {
                \Log::error('Error assigning role during vendor registration: ' . $e->getMessage());
            }

            // Attach selected services
            if (isset($registrationData['service_types']) && is_array($registrationData['service_types'])) {
                try {
                    $user->services()->attach($registrationData['service_types']);
                } catch (QueryException $e) {
                    \Log::error('Error attaching services during vendor registration: ' . $e->getMessage());
                }
            }

            // Clear registration data from session
            Session::forget('vendor_registration_data');

            event(new Registered($user));

            return redirect()->route('login')
                ->with('success', 'Your vendor account has been created and is pending approval. You will be notified when your account is approved.');
        } catch (\Exception $e) {
            \Log::error('Error during vendor OTP verification: ' . $e->getMessage());
            return back()
                ->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
    
    /**
     * Resend OTP for vendor registration.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendOtp()
    {
        try {
            // Get registration data from session
            $registrationData = Session::get('vendor_registration_data');

            if (!$registrationData) {
                return redirect()->route('vendor.register')
                    ->with('error', 'Registration data not found. Please try again.');
            }

            // Generate new OTP
            $otp = Otp::generateForPhone($registrationData['phone'], 'vendor_registration');

            // Send OTP via SMS
            $result = $this->smsService->sendOtp($registrationData['phone'], $otp->otp);

            if ($result['success']) {
                return back()
                    ->with('success', 'OTP resent successfully to your phone number.');
            } else {
                return back()
                    ->with('error', 'Failed to resend OTP. ' . $result['message']);
            }
        } catch (\Exception $e) {
            \Log::error('Error resending vendor registration OTP: ' . $e->getMessage());
            return back()
                ->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
