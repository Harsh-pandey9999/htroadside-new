<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestNote extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'service_request_id',
        'user_id',
        'content',
        'is_private'
    ];
    
    protected $casts = [
        'is_private' => 'boolean'
    ];
    
    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function scopePrivate($query)
    {
        return $query->where('is_private', true);
    }
    
    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }
    
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M d, Y h:i A');
    }
}
