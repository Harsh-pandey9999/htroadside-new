<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'requirements',
        'responsibilities',
        'location',
        'type', // full-time, part-time, contract, temporary
        'category',
        'salary_min',
        'salary_max',
        'salary_currency',
        'salary_period', // hourly, daily, weekly, monthly, yearly
        'is_remote',
        'is_featured',
        'is_active',
        'application_deadline',
        'posted_by', // user_id of the admin who posted the job
        'company_name',
        'company_website',
        'company_logo',
        'contact_email',
        'application_url',
        'views_count',
        'applications_count'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_remote' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'application_deadline' => 'datetime',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'views_count' => 'integer',
        'applications_count' => 'integer'
    ];

    /**
     * Get the admin user who posted this job.
     */
    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    /**
     * Get the applications for this job.
     */
    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Scope a query to only include active jobs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured jobs.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include jobs that haven't passed their deadline.
     */
    public function scopeAvailable($query)
    {
        return $query->where(function($q) {
            $q->whereNull('application_deadline')
              ->orWhere('application_deadline', '>=', now());
        });
    }
}
