<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('customer.profile.edit', compact('user'));
    }
    
    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('customer.profile.edit')
                ->withErrors($validator)
                ->withInput();
        }
        
        // Update user data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->postal_code = $request->postal_code;
        
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }
            
            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
        }
        
        $user->save();
        
        return redirect()->route('customer.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
    
    /**
     * Show the form for editing vehicle information.
     */
    public function editVehicles()
    {
        $user = Auth::user();
        $vehicles = $user->vehicles;
        
        return view('customer.profile.vehicles', compact('vehicles'));
    }
    
    /**
     * Update notification preferences.
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'marketing_emails' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('customer.profile.edit')
                ->withErrors($validator)
                ->withInput();
        }
        
        // Update notification preferences
        $user->notification_preferences = [
            'email' => $request->email_notifications ?? false,
            'sms' => $request->sms_notifications ?? false,
            'push' => $request->push_notifications ?? false,
            'marketing' => $request->marketing_emails ?? false,
        ];
        
        $user->save();
        
        return redirect()->route('customer.profile.edit')
            ->with('success', 'Notification preferences updated successfully.');
    }
}
