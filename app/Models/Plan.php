<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'duration_days',
        'is_active',
        'features',
        'max_service_requests',
        'priority_support',
        'discount_percentage',
        'recommended'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'features' => 'array',
        'priority_support' => 'boolean',
        'discount_percentage' => 'decimal:2',
        'recommended' => 'boolean'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    
    public function activeSubscriptions()
    {
        return $this->subscriptions()->where('expires_at', '>', now());
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeRecommended($query)
    {
        return $query->where('recommended', true);
    }
    
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }
    
    public function getFormattedDurationAttribute()
    {
        if ($this->duration_days % 365 === 0) {
            $years = $this->duration_days / 365;
            return $years . ' ' . ($years === 1 ? 'year' : 'years');
        }
        
        if ($this->duration_days % 30 === 0) {
            $months = $this->duration_days / 30;
            return $months . ' ' . ($months === 1 ? 'month' : 'months');
        }
        
        if ($this->duration_days % 7 === 0) {
            $weeks = $this->duration_days / 7;
            return $weeks . ' ' . ($weeks === 1 ? 'week' : 'weeks');
        }
        
        return $this->duration_days . ' ' . ($this->duration_days === 1 ? 'day' : 'days');
    }
    
    public function getMonthlyPriceAttribute()
    {
        if ($this->duration_days <= 0) {
            return 0;
        }
        
        $monthlyPrice = ($this->price / $this->duration_days) * 30;
        return round($monthlyPrice, 2);
    }
    
    public function getFormattedMonthlyPriceAttribute()
    {
        return '$' . number_format($this->monthly_price, 2);
    }
    
    public function getDiscountedPriceAttribute()
    {
        if (!$this->discount_percentage) {
            return $this->price;
        }
        
        return $this->price * (1 - ($this->discount_percentage / 100));
    }
    
    public function getFormattedDiscountedPriceAttribute()
    {
        return '$' . number_format($this->discounted_price, 2);
    }
    
    public function getSavingsAmountAttribute()
    {
        if (!$this->discount_percentage) {
            return 0;
        }
        
        return $this->price - $this->discounted_price;
    }
    
    public function getFormattedSavingsAmountAttribute()
    {
        return '$' . number_format($this->savings_amount, 2);
    }
    
    public function getActiveSubscribersCountAttribute()
    {
        return $this->activeSubscriptions()->count();
    }
    
    public function getTotalRevenueAttribute()
    {
        return $this->payments()->where('status', 'success')->sum('amount');
    }
    
    public function getFormattedTotalRevenueAttribute()
    {
        return '$' . number_format($this->total_revenue, 2);
    }
}
