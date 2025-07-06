@extends('admin.layouts.material')

@section('title', 'Admin Profile')
@section('page_title', 'Admin Profile & Settings')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Profile Information -->
    <div class="lg:col-span-2">
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-xl font-medium text-on-surface-high">Profile Information</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="flex flex-col md:flex-row gap-6 mb-6">
                        <div class="flex flex-col items-center">
                            <div class="w-32 h-32 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mb-4 overflow-hidden">
                                @if($admin->profile_image)
                                    <img src="{{ asset('storage/' . $admin->profile_image) }}" alt="{{ $admin->name }}" class="w-32 h-32 object-cover">
                                @else
                                    <span class="material-icons text-6xl text-primary-500 dark:text-primary-400">admin_panel_settings</span>
                                @endif
                            </div>
                            
                            <div class="md-input-field w-full">
                                <input type="file" id="profile_image" name="profile_image" class="md-input" accept="image/*">
                                <label for="profile_image">Change Profile Image</label>
                            </div>
                        </div>
                        
                        <div class="flex-1">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div class="md-input-field">
                                    <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" class="md-input" required>
                                    <label for="name">Full Name</label>
                                    @error('name')
                                        <span class="text-error-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="md-input-field">
                                    <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" class="md-input" required>
                                    <label for="email">Email Address</label>
                                    @error('email')
                                        <span class="text-error-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="md-input-field">
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $admin->phone) }}" class="md-input" required>
                                    <label for="phone">Phone Number</label>
                                    @error('phone')
                                        <span class="text-error-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="md-input-field">
                                    <select id="role" name="role" class="md-select" {{ auth()->user()->is_super_admin ? '' : 'disabled' }}>
                                        <option value="admin" {{ $admin->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="super_admin" {{ $admin->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                    </select>
                                    <label for="role">Admin Role</label>
                                    @error('role')
                                        <span class="text-error-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="md-input-field mb-4">
                                <textarea id="bio" name="bio" class="md-input" rows="3">{{ old('bio', $admin->bio) }}</textarea>
                                <label for="bio">Bio</label>
                                @error('bio')
                                    <span class="text-error-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="md-btn md-btn-filled">
                            <span class="material-icons mr-1">save</span>
                            Save Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-xl font-medium text-on-surface-high">Change Password</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('admin.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="md-input-field">
                            <input type="password" id="current_password" name="current_password" class="md-input" required>
                            <label for="current_password">Current Password</label>
                            @error('current_password')
                                <span class="text-error-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div></div>
                        
                        <div class="md-input-field">
                            <input type="password" id="password" name="password" class="md-input" required>
                            <label for="password">New Password</label>
                            @error('password')
                                <span class="text-error-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="md-input-field">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="md-input" required>
                            <label for="password_confirmation">Confirm New Password</label>
                        </div>
                    </div>
                    
                    <div class="md-card p-4 bg-info-50 dark:bg-info-900 dark:bg-opacity-30 border-l-4 border-info-500 dark:border-info-400 mb-4">
                        <div class="flex items-start">
                            <span class="material-icons mr-2 text-info-600 dark:text-info-400">info</span>
                            <div>
                                <h3 class="font-medium text-info-700 dark:text-info-300">Password Requirements</h3>
                                <p class="text-info-700 dark:text-info-300 opacity-80">Password must be at least 8 characters long and include uppercase, lowercase, numbers, and special characters.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="md-btn md-btn-filled">
                            <span class="material-icons mr-1">lock</span>
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-xl font-medium text-on-surface-high">Two-Factor Authentication</h2>
            </div>
            
            <div class="p-6">
                @if(!$admin->two_factor_enabled)
                    <div class="mb-6">
                        <p class="text-on-surface-high mb-4">Two-factor authentication adds an extra layer of security to your account. When enabled, you will be required to provide a secure, random token during login in addition to your password.</p>
                        
                        <form action="{{ route('admin.2fa.enable') }}" method="POST">
                            @csrf
                            <button type="submit" class="md-btn md-btn-filled">
                                <span class="material-icons mr-1">security</span>
                                Enable Two-Factor Authentication
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mb-6">
                        <div class="md-card p-4 bg-success-50 dark:bg-success-900 dark:bg-opacity-30 border-l-4 border-success-500 dark:border-success-400 mb-4">
                            <div class="flex items-start">
                                <span class="material-icons mr-2 text-success-600 dark:text-success-400">check_circle</span>
                                <div>
                                    <h3 class="font-medium text-success-700 dark:text-success-300">Two-Factor Authentication is Enabled</h3>
                                    <p class="text-success-700 dark:text-success-300 opacity-80">Your account is protected with an additional layer of security.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-on-surface-high mb-2">Recovery Codes</h3>
                            <p class="text-on-surface-medium mb-4">Store these recovery codes in a secure location. They can be used to recover access to your account if you lose your two-factor authentication device.</p>
                            
                            <div class="bg-surface-2 dark:bg-surface-2-dark p-4 rounded-md mb-4 font-mono text-sm">
                                @foreach($recoveryCodes as $code)
                                    <div class="mb-1">{{ $code }}</div>
                                @endforeach
                            </div>
                            
                            <form action="{{ route('admin.2fa.regenerate-codes') }}" method="POST" class="mb-4">
                                @csrf
                                <button type="submit" class="md-btn md-btn-outlined">
                                    <span class="material-icons mr-1">refresh</span>
                                    Regenerate Recovery Codes
                                </button>
                            </form>
                        </div>
                        
                        <form action="{{ route('admin.2fa.disable') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="md-btn md-btn-outlined md-btn-error">
                                <span class="material-icons mr-1">no_encryption</span>
                                Disable Two-Factor Authentication
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <!-- Account Status -->
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-lg font-medium text-on-surface-high">Account Status</h2>
            </div>
            
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mr-4">
                        <span class="material-icons text-primary-600 dark:text-primary-400">
                            {{ $admin->is_super_admin ? 'security' : 'admin_panel_settings' }}
                        </span>
                    </div>
                    <div>
                        <h3 class="font-medium text-on-surface-high">{{ $admin->is_super_admin ? 'Super Admin' : 'Administrator' }}</h3>
                        <p class="text-on-surface-medium text-sm">Account active since {{ $admin->created_at->format('M Y') }}</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-on-surface-medium">Last Login</span>
                        <span class="text-on-surface-high">{{ $admin->last_login_at ? $admin->last_login_at->format('M d, Y H:i') : 'Never' }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-on-surface-medium">Two-Factor Auth</span>
                        @if($admin->two_factor_enabled)
                            <span class="md-chip md-chip-success">Enabled</span>
                        @else
                            <span class="md-chip md-chip-error">Disabled</span>
                        @endif
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-on-surface-medium">Account Status</span>
                        @if($admin->is_active)
                            <span class="md-chip md-chip-success">Active</span>
                        @else
                            <span class="md-chip md-chip-error">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Notification Settings -->
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-lg font-medium text-on-surface-high">Notification Settings</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('admin.notifications.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div class="md-checkbox">
                            <input type="checkbox" id="email_notifications" name="email_notifications" value="1" {{ $admin->email_notifications ? 'checked' : '' }}>
                            <label for="email_notifications">Email Notifications</label>
                        </div>
                        
                        <div class="md-checkbox">
                            <input type="checkbox" id="new_provider_alerts" name="new_provider_alerts" value="1" {{ $admin->new_provider_alerts ? 'checked' : '' }}>
                            <label for="new_provider_alerts">New Provider Alerts</label>
                        </div>
                        
                        <div class="md-checkbox">
                            <input type="checkbox" id="system_alerts" name="system_alerts" value="1" {{ $admin->system_alerts ? 'checked' : '' }}>
                            <label for="system_alerts">System Alerts</label>
                        </div>
                        
                        <div class="md-checkbox">
                            <input type="checkbox" id="customer_support_alerts" name="customer_support_alerts" value="1" {{ $admin->customer_support_alerts ? 'checked' : '' }}>
                            <label for="customer_support_alerts">Customer Support Alerts</label>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="md-btn md-btn-filled">
                            <span class="material-icons mr-1">notifications</span>
                            Save Preferences
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Activity Log -->
        <div class="md-card md-card-elevated mb-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-lg font-medium text-on-surface-high">Recent Activity</h2>
            </div>
            
            <div class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse($activityLogs as $log)
                    <div class="p-4">
                        <div class="flex items-start">
                            <span class="material-icons text-on-surface-medium mr-3">{{ $log->icon }}</span>
                            <div>
                                <p class="text-on-surface-high">{{ $log->description }}</p>
                                <p class="text-on-surface-medium text-xs mt-1">{{ $log->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center">
                        <span class="material-icons text-4xl text-on-surface-disabled mb-2">history</span>
                        <p class="text-on-surface-medium">No recent activity</p>
                    </div>
                @endforelse
            </div>
            
            @if(count($activityLogs) > 0)
                <div class="p-4 border-t border-neutral-200 dark:border-neutral-700 text-center">
                    <a href="{{ route('admin.activity-log') }}" class="text-primary-600 dark:text-primary-400 text-sm font-medium">
                        View Full Activity Log
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Session Management -->
        <div class="md-card md-card-elevated">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-lg font-medium text-on-surface-high">Active Sessions</h2>
            </div>
            
            <div class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @foreach($sessions as $session)
                    <div class="p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start">
                                <span class="material-icons text-on-surface-medium mr-3">
                                    {{ $session->is_current ? 'phonelink' : ($session->device == 'mobile' ? 'smartphone' : 'computer') }}
                                </span>
                                <div>
                                    <p class="text-on-surface-high">
                                        {{ $session->browser }} on {{ $session->platform }}
                                        @if($session->is_current)
                                            <span class="md-chip md-chip-small md-chip-success ml-2">Current</span>
                                        @endif
                                    </p>
                                    <p class="text-on-surface-medium text-xs mt-1">
                                        {{ $session->ip_address }} • Last active {{ $session->last_active }}
                                    </p>
                                </div>
                            </div>
                            
                            @if(!$session->is_current)
                                <form action="{{ route('admin.sessions.destroy', $session->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="md-btn md-btn-icon md-btn-text text-error-500" title="Logout Session">
                                        <span class="material-icons">logout</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="p-4 border-t border-neutral-200 dark:border-neutral-700">
                <form action="{{ route('admin.sessions.destroy-all') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="md-btn md-btn-outlined md-btn-error w-full">
                        <span class="material-icons mr-1">logout</span>
                        Logout From All Other Devices
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
