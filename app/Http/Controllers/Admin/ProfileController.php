<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the admin profile page.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();
        
        // Get recent activity
        $recentActivity = \App\Models\ActivityLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Get active sessions
        $sessions = \DB::table('sessions')
            ->where('user_id', $user->id)
            ->get();
            
        // Determine which design version to use based on session
        $designVersion = session('design_version', 'original');
        if ($designVersion === 'material') {
            return view('admin.profile-material', compact('user', 'recentActivity', 'sessions'));
        } else {
            return view('admin.profile.show', compact('user', 'recentActivity', 'sessions'));
        }
    }
    
    /**
     * Update the admin profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|max:2048',
        ]);
        
        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
        }
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? $user->phone;
        $user->bio = $validated['bio'] ?? $user->bio;
        $user->save();
        
        // Log activity
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'profile_updated',
            'description' => 'Updated profile information',
            'ip_address' => $request->ip(),
        ]);
        
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    
    /**
     * Update the admin password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        // Check current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
        
        $user->password = Hash::make($validated['password']);
        $user->save();
        
        // Log activity
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'password_changed',
            'description' => 'Changed account password',
            'ip_address' => $request->ip(),
        ]);
        
        return redirect()->back()->with('success', 'Password updated successfully.');
    }
    
    /**
     * Update notification settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        $user->notification_preferences = [
            'email_notifications' => $request->has('email_notifications'),
            'new_provider_alerts' => $request->has('new_provider_alerts'),
            'system_alerts' => $request->has('system_alerts'),
            'customer_support_alerts' => $request->has('customer_support_alerts'),
        ];
        
        $user->save();
        
        return redirect()->back()->with('success', 'Notification preferences updated successfully.');
    }
    
    /**
     * Logout from other devices.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutOtherDevices(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string',
        ]);
        
        $user = Auth::user();
        
        // Check password
        if (!Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['password' => 'The password is incorrect.']);
        }
        
        // Delete other sessions
        \DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', session()->getId())
            ->delete();
            
        return redirect()->back()->with('success', 'Logged out from all other devices.');
    }
}
