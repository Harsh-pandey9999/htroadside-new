<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'slug',
        'department',
        'location',
        'type',
        'description',
        'responsibilities',
        'requirements',
        'benefits',
        'salary_min',
        'salary_max',
        'is_active',
        'expires_at',
        'featured'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'featured' => 'boolean',
        'responsibilities' => 'array',
        'requirements' => 'array',
        'benefits' => 'array',
        'expires_at' => 'datetime',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2'
    ];
    
    /**
     * Get all applications for this job
     */
    public function applications()
    {
        return $this->hasMany(CareerApplication::class);
    }
    
    /**
     * Scope a query to only include active jobs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where(function($q) {
                         $q->whereNull('expires_at')
                           ->orWhere('expires_at', '>', now());
                     });
    }
    
    /**
     * Scope a query to only include featured jobs
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
    
    /**
     * Get the formatted salary range
     */
    public function getFormattedSalaryAttribute()
    {
        if (!$this->salary_min && !$this->salary_max) {
            return 'Competitive';
        }
        
        if ($this->salary_min && !$this->salary_max) {
            return '$' . number_format($this->salary_min, 0) . '+';
        }
        
        if (!$this->salary_min && $this->salary_max) {
            return 'Up to $' . number_format($this->salary_max, 0);
        }
        
        return '$' . number_format($this->salary_min, 0) . ' - $' . number_format($this->salary_max, 0);
    }
    
    /**
     * Get the application count
     */
    public function getApplicationCountAttribute()
    {
        return $this->applications()->count();
    }
    
    /**
     * Get the new application count (unread)
     */
    public function getNewApplicationCountAttribute()
    {
        return $this->applications()->where('viewed', false)->count();
    }
}
