<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestStatusUpdate extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'service_request_id',
        'user_id',
        'previous_status',
        'new_status',
        'comment',
        'location',
        'latitude',
        'longitude'
    ];
    
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];
    
    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M d, Y h:i A');
    }
    
    public function getStatusChangeTextAttribute()
    {
        $statusMap = [
            'new' => 'New Request',
            'assigned' => 'Provider Assigned',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];
        
        $previousStatus = $statusMap[$this->previous_status] ?? ucfirst($this->previous_status);
        $newStatus = $statusMap[$this->new_status] ?? ucfirst($this->new_status);
        
        return "Status changed from {$previousStatus} to {$newStatus}";
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
        
        return $colorMap[$this->new_status] ?? 'gray';
    }
    
    public function hasLocationData()
    {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }
    
    public function getMapUrlAttribute()
    {
        if (!$this->hasLocationData()) {
            return null;
        }
        
        return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
    }
}
