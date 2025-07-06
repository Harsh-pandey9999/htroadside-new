<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'job_id',
        'cover_letter',
        'resume_path',
        'phone',
        'linkedin_profile',
        'portfolio_url',
        'additional_information',
        'status', // pending, reviewing, shortlisted, interview, offered, rejected, withdrawn
        'admin_notes',
        'interview_date',
        'interview_location',
        'withdrawal_reason',
        'terms_accepted'
    ];
    
    protected $casts = [
        'interview_date' => 'datetime',
    ];
    
    /**
     * Get the user that owns the job application.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the job that this application is for.
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    
    /**
     * Scope a query to only include applications with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    
    /**
     * Scope a query to only include applications that need review.
     */
    public function scopeNeedsReview($query)
    {
        return $query->where('status', 'pending');
    }
}
