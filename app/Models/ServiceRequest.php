<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'vehicle_number',
        'location',
        'message',
        'service_id',
        'status',
        'user_id',
        'provider_id',
        'responded_at',
        'completed_at',
        'cancelled_at',
        'admin_notes',
        'latitude',
        'longitude',
        'vehicle_make',
        'vehicle_model',
        'vehicle_year',
        'emergency_level',
        'estimated_arrival_time',
        'actual_arrival_time',
        'payment_status',
        'payment_amount',
        'payment_method',
        'payment_id',
        'rating',
        'review'
    ];
    
    protected $casts = [
        'responded_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'estimated_arrival_time' => 'datetime',
        'actual_arrival_time' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'payment_amount' => 'decimal:2',
        'rating' => 'decimal:1'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function assignedProvider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
    
    public function notes()
    {
        return $this->hasMany(ServiceRequestNote::class);
    }
    
    public function attachments()
    {
        return $this->hasMany(ServiceRequestAttachment::class);
    }
    
    public function statusUpdates()
    {
        return $this->hasMany(ServiceRequestStatusUpdate::class)->orderBy('created_at', 'desc');
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class, 'service_request_id');
    }
    
    public function scopePending($query)
    {
        return $query->whereIn('status', ['new', 'assigned']);
    }
    
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }
    
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
    
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
    
    public function scopeByProvider($query, $providerId)
    {
        return $query->where('provider_id', $providerId);
    }
    
    public function getFormattedStatusAttribute()
    {
        $statusMap = [
            'new' => 'New Request',
            'assigned' => 'Provider Assigned',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];
        
        return $statusMap[$this->status] ?? ucfirst($this->status);
    }
    
    public function getStatusColorAttribute()
    {
        $colorMap = [
            'new' => 'blue',
            'assigned' => 'indigo',
            'in_progress' => 'yellow',
            'completed' => 'green',
            'cancelled' => 'red'
        ];
        
        return $colorMap[$this->status] ?? 'gray';
    }
    
    public function getFormattedPaymentAmountAttribute()
    {
        return '$' . number_format($this->payment_amount, 2);
    }
    
    public function getDurationAttribute()
    {
        if (!$this->completed_at || !$this->responded_at) {
            return null;
        }
        
        return $this->responded_at->diffInMinutes($this->completed_at);
    }
    
    public function getFormattedDurationAttribute()
    {
        $duration = $this->duration;
        
        if ($duration === null) {
            return 'N/A';
        }
        
        $hours = floor($duration / 60);
        $minutes = $duration % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        
        return $minutes . 'm';
    }
    
    public function getResponseTimeAttribute()
    {
        if (!$this->responded_at) {
            return null;
        }
        
        return $this->created_at->diffInMinutes($this->responded_at);
    }
    
    public function getFormattedResponseTimeAttribute()
    {
        $responseTime = $this->response_time;
        
        if ($responseTime === null) {
            return 'Not responded yet';
        }
        
        if ($responseTime < 60) {
            return $responseTime . ' minutes';
        }
        
        $hours = floor($responseTime / 60);
        $minutes = $responseTime % 60;
        
        return $hours . 'h ' . $minutes . 'm';
    }
}
