<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'name',
        'relationship',
        'phone',
        'email',
        'address',
        'is_primary',
        'notify_on_emergency',
        'notify_on_service_request',
        'notify_on_service_completion'
    ];
    
    protected $casts = [
        'is_primary' => 'boolean',
        'notify_on_emergency' => 'boolean',
        'notify_on_service_request' => 'boolean',
        'notify_on_service_completion' => 'boolean'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function notifications()
    {
        return $this->hasMany(EmergencyContactNotification::class);
    }
    
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }
    
    public function scopeNotifyOnEmergency($query)
    {
        return $query->where('notify_on_emergency', true);
    }
    
    public function scopeNotifyOnServiceRequest($query)
    {
        return $query->where('notify_on_service_request', true);
    }
    
    public function scopeNotifyOnServiceCompletion($query)
    {
        return $query->where('notify_on_service_completion', true);
    }
    
    public function makePrimary()
    {
        // First, remove primary status from all other contacts
        static::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_primary' => false]);
        
        // Set this contact as primary
        $this->is_primary = true;
        $this->save();
        
        return $this;
    }
    
    public function getFormattedPhoneAttribute()
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        
        if (strlen($phone) === 10) {
            return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6);
        }
        
        return $this->phone;
    }
    
    public function sendNotification($message, $type = 'emergency')
    {
        // In a real implementation, this would send an SMS or email notification
        // For now, we'll just create a record in the database
        
        return $this->notifications()->create([
            'type' => $type,
            'message' => $message,
            'sent_at' => now(),
            'status' => 'sent'
        ]);
    }
}
