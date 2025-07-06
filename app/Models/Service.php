<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 
        'slug', 
        'short_description', 
        'description', 
        'icon', 
        'image', 
        'is_active',
        'price',
        'estimated_time',
        'category',
        'tags',
        'featured',
        'service_area'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'featured' => 'boolean',
        'tags' => 'array',
        'price' => 'decimal:2',
    ];

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }
    
    public function providers()
    {
        return $this->belongsToMany(User::class, 'service_provider', 'service_id', 'user_id')
            ->where('is_service_provider', true)
            ->withTimestamps();
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * Get the appropriate image URL for this service
     * Falls back to wbg folder images if no image is set
     */
    public function getImageUrlAttribute()
    {
        if (!empty($this->image) && Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }
        
        // Map service slugs to appropriate wbg images
        $imageMap = [
            'towing' => 'car-with-map.png',
            'jump-start' => 'battery-jumpstart.png',
            'flat-tire' => 'flat-tyre-change.png',
            'fuel-delivery' => 'e-wallet-concept-illustration.png',
            'lockout' => 'key-lockout-1.png',
            'battery-replacement' => 'battery-jumpstart.png',
            'winching' => 'changing-flat-tyre.png',
            'trip-interruption' => 'customer-with-mechanic.png',
            'rental-car' => 'changing-flat-tyre.png'
        ];
        
        $imageName = $imageMap[$this->slug] ?? 'customer-with-mechanic.png'; // Default fallback image
        return asset('images/wbg/' . $imageName);
    }
    
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
    
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
    
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }
    
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }
}
