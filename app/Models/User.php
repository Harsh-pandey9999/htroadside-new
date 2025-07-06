<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'bio',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'is_admin',
        'is_service_provider',
        'service_provider_type',
        'company_name',
        'service_area',
        'service_types',
        'rating',
        'total_ratings',
        'is_verified',
        'verified_at',
        'email_notifications',
        'sms_notifications',
        'push_notifications',
        'preferred_language',
        'timezone',
        'stripe_customer_id',
        'stripe_account_id',
        'payment_verified',
        'last_active_at',
        'last_active_ip',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'stripe_customer_id',
        'stripe_account_id',
        'last_active_ip'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
        'is_service_provider' => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'push_notifications' => 'boolean',
        'payment_verified' => 'boolean',
        'last_active_at' => 'datetime',
        'service_types' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'rating' => 'decimal:2'
    ];

    /**
     * Get the user's payments.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    /**
     * Get the user's service requests.
     */
    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }
    
    /**
     * Get the service requests assigned to this provider.
     */
    public function assignedServiceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'provider_id');
    }
    
    /**
     * Get the user's emergency contacts.
     */
    public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class);
    }
    
    /**
     * Get the user's reviews.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * Get the reviews written by the user.
     */
    public function reviewsWritten()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }
    
    /**
     * Get the user's job applications.
     */
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
    
    /**
     * Get the user's notifications.
     */
    public function userNotifications()
    {
        return $this->hasMany(UserNotification::class);
    }
    
    /**
     * Get the services provided by this user (for service providers).
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_provider', 'user_id', 'service_id')
            ->withTimestamps();
    }
    
    /**
     * Get the user's active subscription.
     */
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('expires_at', '>', now())->latest();
    }
    
    /**
     * Check if the user is an admin.
     */
    public function isAdmin()
    {
        return $this->is_admin === true;
    }
    
    /**
     * Check if the user is a service provider.
     */
    public function isServiceProvider()
    {
        return $this->is_service_provider === true;
    }
    
    /**
     * Check if the user is verified.
     */
    public function isVerified()
    {
        return $this->is_verified === true;
    }
    
    /**
     * Get the user's profile photo URL.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        
        // Return default avatar based on name initials
        $name = $this->name ?? 'User';
        $initials = strtoupper(substr($name, 0, 1));
        
        if (strpos($name, ' ') !== false) {
            $nameParts = explode(' ', $name);
            $initials = strtoupper(substr($nameParts[0], 0, 1) . substr(end($nameParts), 0, 1));
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($initials) . '&color=7F9CF5&background=EBF4FF';
    }
    
    /**
     * Get the user's role name.
     */
    public function getRoleAttribute()
    {
        if ($this->is_admin) {
            return 'Admin';
        }
        
        if ($this->is_service_provider) {
            return 'Service Provider';
        }
        
        return 'Customer';
    }
    
    /**
     * Get the user's full address.
     */
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country
        ]);
        
        return implode(', ', $parts);
    }
    
    /**
     * Scope a query to only include admin users.
     */
    public function scopeAdmins($query)
    {
        return $query->where('is_admin', true);
    }
    
    /**
     * Scope a query to only include service providers.
     */
    public function scopeServiceProviders($query)
    {
        return $query->where('is_service_provider', true);
    }
    
    /**
     * Scope a query to only include verified users.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
    
    /**
     * Scope a query to only include customers (not admins or service providers).
     */
    public function scopeCustomers($query)
    {
        return $query->where('is_admin', false)->where('is_service_provider', false);
    }
    
    /**
     * Get the user's completed service requests count.
     */
    public function getCompletedRequestsCountAttribute()
    {
        if ($this->is_service_provider) {
            return $this->assignedServiceRequests()->where('status', 'completed')->count();
        }
        
        return $this->serviceRequests()->where('status', 'completed')->count();
    }
    
    /**
     * Update user's last active timestamp.
     */
    public function updateLastActive($ip = null)
    {
        $this->last_active_at = now();
        
        if ($ip) {
            $this->last_active_ip = $ip;
        }
        
        return $this->save();
    }
    
    /**
     * Get the roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    
    /**
     * Assign a role to the user.
     */
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }
        
        $this->roles()->syncWithoutDetaching($role);
        $this->flushPermissionCache();
        
        return $this;
    }
    
    /**
     * Remove a role from the user.
     */
    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }
        
        $this->roles()->detach($role);
        $this->flushPermissionCache();
        
        return $this;
    }
    
    /**
     * Check if the user has a specific role.
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles()->where('slug', $role)->exists();
        }
        
        return $this->roles->contains($role);
    }
    
    /**
     * Check if the user has any of the given roles.
     */
    public function hasAnyRole($roles)
    {
        if (is_string($roles)) {
            return $this->hasRole($roles);
        }
        
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Check if the user has all of the given roles.
     */
    public function hasAllRoles($roles)
    {
        if (is_string($roles)) {
            return $this->hasRole($roles);
        }
        
        foreach ($roles as $role) {
            if (!$this->hasRole($role)) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Check if the user has a specific permission.
     */
    public function hasPermission($permission)
    {
        $cacheKey = "user_{$this->id}_has_permission_{$permission}";
        
        return Cache::remember($cacheKey, now()->addHours(24), function () use ($permission) {
            // Check if user is admin (has all permissions)
            if ($this->is_admin) {
                return true;
            }
            
            // Check if any of the user's roles have this permission
            foreach ($this->roles as $role) {
                if ($role->hasPermission($permission)) {
                    return true;
                }
            }
            
            return false;
        });
    }
    
    /**
     * Flush the permission cache for this user.
     */
    public function flushPermissionCache()
    {
        $cacheKeys = Cache::get("user_{$this->id}_permission_cache_keys", []);
        
        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
        
        Cache::forget("user_{$this->id}_permission_cache_keys");
        
        return $this;
    }
}
