<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'billing_cycle',
        'features',
        'is_active',
        'is_featured',
        'sort_order',
    ];
    
    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
    ];
    
    /**
     * Get all subscriptions for this plan.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
    
    /**
     * Get active subscriptions for this plan.
     */
    public function activeSubscriptions()
    {
        return $this->subscriptions()->active();
    }
    
    /**
     * Scope a query to only include active plans.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope a query to only include featured plans.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
    
    /**
     * Get the formatted price attribute.
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }
    
    /**
     * Get the formatted billing cycle attribute.
     */
    public function getFormattedBillingCycleAttribute()
    {
        if ($this->billing_cycle === 'monthly') {
            return 'Monthly';
        } elseif ($this->billing_cycle === 'quarterly') {
            return 'Quarterly';
        } elseif ($this->billing_cycle === 'yearly') {
            return 'Yearly';
        }
        
        return ucfirst($this->billing_cycle);
    }
    
    /**
     * Get the full price description.
     */
    public function getPriceDescriptionAttribute()
    {
        return $this->formatted_price . ' / ' . $this->formatted_billing_cycle;
    }
}
