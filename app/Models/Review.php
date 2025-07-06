<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'reviewer_id',
        'service_id',
        'service_request_id',
        'rating',
        'title',
        'comment',
        'is_verified',
        'is_published',
        'admin_response',
        'admin_response_at'
    ];
    
    protected $casts = [
        'rating' => 'decimal:1',
        'is_verified' => 'boolean',
        'is_published' => 'boolean',
        'admin_response_at' => 'datetime'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }
    
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
    
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
    
    public function scopeHighRated($query, $minRating = 4)
    {
        return $query->where('rating', '>=', $minRating);
    }
    
    public function scopeLowRated($query, $maxRating = 2)
    {
        return $query->where('rating', '<=', $maxRating);
    }
    
    public function scopeWithResponse($query)
    {
        return $query->whereNotNull('admin_response');
    }
    
    public function scopeWithoutResponse($query)
    {
        return $query->whereNull('admin_response');
    }
    
    public function getRatingStarsAttribute()
    {
        $fullStars = floor($this->rating);
        $halfStar = ($this->rating - $fullStars) >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        
        $stars = str_repeat('★', $fullStars) . 
                 ($halfStar ? '½' : '') . 
                 str_repeat('☆', $emptyStars);
        
        return $stars;
    }
    
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M d, Y');
    }
    
    public function getShortCommentAttribute()
    {
        if (strlen($this->comment) <= 100) {
            return $this->comment;
        }
        
        return substr($this->comment, 0, 100) . '...';
    }
    
    public function publish()
    {
        $this->is_published = true;
        $this->save();
        
        return $this;
    }
    
    public function unpublish()
    {
        $this->is_published = false;
        $this->save();
        
        return $this;
    }
    
    public function verify()
    {
        $this->is_verified = true;
        $this->save();
        
        return $this;
    }
    
    public function respond($response)
    {
        $this->admin_response = $response;
        $this->admin_response_at = now();
        $this->save();
        
        return $this;
    }
}
