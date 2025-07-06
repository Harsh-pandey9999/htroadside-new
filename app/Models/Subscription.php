<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'plan_id',
        'payment_id',
        'starts_at',
        'expires_at',
        'status',
        'is_active',
        'is_trial',
        'trial_ends_at',
        'cancelled_at',
        'cancellation_reason',
        'auto_renew',
        'renewal_reminder_sent_at'
    ];
    
    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'renewal_reminder_sent_at' => 'datetime',
        'is_active' => 'boolean',
        'is_trial' => 'boolean',
        'auto_renew' => 'boolean'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    
    public function renewalPayments()
    {
        return $this->hasMany(Payment::class, 'subscription_id');
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('expires_at', '>', now());
    }
    
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }
    
    public function scopeExpiringSoon($query, $days = 7)
    {
        $now = now();
        $soon = now()->addDays($days);
        
        return $query->where('is_active', true)
                    ->whereBetween('expires_at', [$now, $soon]);
    }
    
    public function scopeTrial($query)
    {
        return $query->where('is_trial', true);
    }
    
    public function scopeCancelled($query)
    {
        return $query->whereNotNull('cancelled_at');
    }
    
    public function isActive()
    {
        return $this->is_active && $this->expires_at > now();
    }
    
    public function isExpired()
    {
        return $this->expires_at < now();
    }
    
    public function isInTrial()
    {
        return $this->is_trial && $this->trial_ends_at > now();
    }
    
    public function isCancelled()
    {
        return !is_null($this->cancelled_at);
    }
    
    public function isExpiringSoon($days = 7)
    {
        $soon = now()->addDays($days);
        return $this->is_active && $this->expires_at <= $soon && $this->expires_at > now();
    }
    
    public function getDaysRemainingAttribute()
    {
        if ($this->isExpired()) {
            return 0;
        }
        
        return now()->diffInDays($this->expires_at);
    }
    
    public function getFormattedStatusAttribute()
    {
        if ($this->isActive()) {
            if ($this->isInTrial()) {
                return 'Trial';
            }
            
            if ($this->isCancelled()) {
                return 'Cancelled (Expires: ' . $this->expires_at->format('M d, Y') . ')';
            }
            
            return 'Active';
        }
        
        return 'Expired';
    }
    
    public function getStatusColorAttribute()
    {
        if ($this->isActive()) {
            if ($this->isInTrial()) {
                return 'purple';
            }
            
            if ($this->isCancelled()) {
                return 'orange';
            }
            
            return 'green';
        }
        
        return 'red';
    }
    
    public function getFormattedStartsAtAttribute()
    {
        return $this->starts_at->format('M d, Y');
    }
    
    public function getFormattedExpiresAtAttribute()
    {
        return $this->expires_at->format('M d, Y');
    }
    
    public function cancel($reason = null)
    {
        $this->cancelled_at = now();
        $this->cancellation_reason = $reason;
        $this->auto_renew = false;
        $this->save();
        
        return $this;
    }
    
    public function reactivate()
    {
        $this->cancelled_at = null;
        $this->cancellation_reason = null;
        $this->auto_renew = true;
        $this->save();
        
        return $this;
    }
    
    public function extend($days)
    {
        $this->expires_at = $this->expires_at->addDays($days);
        $this->save();
        
        return $this;
    }
}
