<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerApplication extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'career_id',
        'name',
        'email',
        'phone',
        'cover_letter',
        'resume_path',
        'status',
        'viewed',
        'notes'
    ];
    
    protected $casts = [
        'viewed' => 'boolean',
    ];
    
    /**
     * Status constants
     */
    const STATUS_NEW = 'new';
    const STATUS_REVIEWING = 'reviewing';
    const STATUS_INTERVIEW = 'interview';
    const STATUS_REJECTED = 'rejected';
    const STATUS_HIRED = 'hired';
    
    /**
     * Get all possible statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_REVIEWING => 'Reviewing',
            self::STATUS_INTERVIEW => 'Interview',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_HIRED => 'Hired'
        ];
    }
    
    /**
     * Get the job this application is for
     */
    public function career()
    {
        return $this->belongsTo(Career::class);
    }
    
    /**
     * Get the status label
     */
    public function getStatusLabelAttribute()
    {
        return self::getStatuses()[$this->status] ?? 'Unknown';
    }
    
    /**
     * Get the status color class
     */
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case self::STATUS_NEW:
                return 'bg-blue-100 text-blue-800';
            case self::STATUS_REVIEWING:
                return 'bg-yellow-100 text-yellow-800';
            case self::STATUS_INTERVIEW:
                return 'bg-purple-100 text-purple-800';
            case self::STATUS_REJECTED:
                return 'bg-red-100 text-red-800';
            case self::STATUS_HIRED:
                return 'bg-green-100 text-green-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }
    
    /**
     * Scope a query to only include unread applications
     */
    public function scopeUnread($query)
    {
        return $query->where('viewed', false);
    }
    
    /**
     * Mark the application as viewed
     */
    public function markAsViewed()
    {
        $this->update(['viewed' => true]);
    }
}
