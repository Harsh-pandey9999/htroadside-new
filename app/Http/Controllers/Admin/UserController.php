<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        // Filter by role
        if ($request->has('role')) {
            if ($request->role === 'admin') {
                $query->where('is_admin', true);
            } elseif ($request->role === 'service_provider') {
                $query->where('is_service_provider', true);
            } elseif ($request->role === 'customer') {
                $query->where('is_admin', false)->where('is_service_provider', false);
            }
        }
        
        // Filter by verification status
        if ($request->has('verified')) {
            $query->where('is_verified', $request->verified == 'true');
        }
        
        // Search by name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            });
        }
        
        // Sort results
        $sortField = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query->orderBy($sortField, $sortDirection);
        
        $users = $query->paginate(15)->withQueryString();
        
        // Determine which design version to use based on session
        $designVersion = session('design_version', 'original');
        
        // If we're viewing service providers and using material design
        if ($designVersion === 'material' && $request->has('role') && $request->role === 'service_provider') {
            return view('admin.providers-material', compact('users'));
        } else {
            return view('admin.users.index', compact('users'));
        }
    }
    
    public function create()
    {
        return view('admin.users.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'boolean',
            'is_service_provider' => 'boolean',
            'profile_photo' => 'nullable|image|max:2048',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'service_provider_type' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'service_area' => 'nullable|string|max:255',
            'service_types' => 'nullable|array',
            'is_verified' => 'boolean',
        ]);
        
        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }
        
        // Convert service types to JSON
        if (isset($validated['service_types'])) {
            $validated['service_types'] = json_encode($validated['service_types']);
        }
        
        // Hash password
        $validated['password'] = Hash::make($validated['password']);
        
        // Set verification timestamp if verified
        if (isset($validated['is_verified']) && $validated['is_verified']) {
            $validated['verified_at'] = now();
        }
        
        $user = User::create($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }
    
    public function show(User $user)
    {
        $user->load(['serviceRequests', 'payments']);
        return view('admin.users.show', compact('user'));
    }
    
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'boolean',
            'is_service_provider' => 'boolean',
            'profile_photo' => 'nullable|image|max:2048',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'service_provider_type' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'service_area' => 'nullable|string|max:255',
            'service_types' => 'nullable|array',
            'is_verified' => 'boolean',
        ]);
        
        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }
        
        // Convert service types to JSON
        if (isset($validated['service_types'])) {
            $validated['service_types'] = json_encode($validated['service_types']);
        }
        
        // Hash password if provided
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        // Set verification timestamp if verified and not already verified
        if (isset($validated['is_verified']) && $validated['is_verified'] && !$user->is_verified) {
            $validated['verified_at'] = now();
        }
        
        $user->update($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }
    
    public function destroy(User $user)
    {
        // Delete profile photo if exists
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
    
    public function verify(User $user)
    {
        $user->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);
        
        return redirect()->back()
            ->with('success', 'User verified successfully.');
    }
    
    public function toggleAdmin(User $user)
    {
        $user->update([
            'is_admin' => !$user->is_admin,
        ]);
        
        return redirect()->back()
            ->with('success', 'User admin status updated successfully.');
    }
    
    public function exportUsers(Request $request)
    {
        $users = User::all();
        
        $csvFileName = 'users-' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        
        $columns = ['ID', 'Name', 'Email', 'Role', 'Verified', 'Created At'];
        
        $callback = function() use($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($users as $user) {
                $role = $user->is_admin ? 'Admin' : ($user->is_service_provider ? 'Service Provider' : 'Customer');
                
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $role,
                    $user->is_verified ? 'Yes' : 'No',
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
