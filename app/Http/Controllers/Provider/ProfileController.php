<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Service;
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
        $services = Service::all();
        
        return view('provider.profile.edit', compact('user', 'services'));
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
            'company_name' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('provider.profile.edit')
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
        $user->company_name = $request->company_name;
        $user->bio = $request->bio;
        
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
        
        return redirect()->route('provider.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
    
    /**
     * Update the provider's service offerings.
     */
    public function updateServices(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
            'service_area' => 'required|string|max:255',
            'service_types' => 'required|array',
            'service_types.*' => 'string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('provider.profile.edit')
                ->withErrors($validator)
                ->withInput();
        }
        
        // Update service area and types
        $user->service_area = $request->service_area;
        $user->service_types = $request->service_types;
        $user->save();
        
        // Sync services
        $user->services()->sync($request->services);
        
        return redirect()->route('provider.profile.edit')
            ->with('success', 'Service offerings updated successfully.');
    }
    
    /**
     * Update the provider's availability.
     */
    public function updateAvailability(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'availability' => 'required|array',
            'availability.days' => 'required|array',
            'availability.days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'availability.hours.start' => 'required|date_format:H:i',
            'availability.hours.end' => 'required|date_format:H:i|after:availability.hours.start',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('provider.profile.edit')
                ->withErrors($validator)
                ->withInput();
        }
        
        // Store availability as JSON
        $user->availability = $request->availability;
        $user->save();
        
        return redirect()->route('provider.profile.edit')
            ->with('success', 'Availability updated successfully.');
    }
}
