<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ServiceRequestAttachment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'service_request_id',
        'user_id',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'description',
        'is_private'
    ];
    
    protected $casts = [
        'file_size' => 'integer',
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
    
    public function scopeImages($query)
    {
        return $query->where('file_type', 'like', 'image/%');
    }
    
    public function scopeDocuments($query)
    {
        return $query->where(function($q) {
            $q->where('file_type', 'like', 'application/pdf')
              ->orWhere('file_type', 'like', 'application/msword')
              ->orWhere('file_type', 'like', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
              ->orWhere('file_type', 'like', 'text/%');
        });
    }
    
    public function getFileUrlAttribute()
    {
        return Storage::disk('public')->url($this->file_path);
    }
    
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        }
        
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }
        
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        
        return $bytes . ' bytes';
    }
    
    public function getFileIconAttribute()
    {
        if (strpos($this->file_type, 'image/') === 0) {
            return 'fa-file-image';
        }
        
        if (strpos($this->file_type, 'video/') === 0) {
            return 'fa-file-video';
        }
        
        if (strpos($this->file_type, 'audio/') === 0) {
            return 'fa-file-audio';
        }
        
        if (strpos($this->file_type, 'application/pdf') === 0) {
            return 'fa-file-pdf';
        }
        
        if (strpos($this->file_type, 'application/msword') === 0 || 
            strpos($this->file_type, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') === 0) {
            return 'fa-file-word';
        }
        
        if (strpos($this->file_type, 'application/vnd.ms-excel') === 0 || 
            strpos($this->file_type, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') === 0) {
            return 'fa-file-excel';
        }
        
        if (strpos($this->file_type, 'application/vnd.ms-powerpoint') === 0 || 
            strpos($this->file_type, 'application/vnd.openxmlformats-officedocument.presentationml.presentation') === 0) {
            return 'fa-file-powerpoint';
        }
        
        if (strpos($this->file_type, 'text/') === 0) {
            return 'fa-file-alt';
        }
        
        if (strpos($this->file_type, 'application/zip') === 0 || 
            strpos($this->file_type, 'application/x-rar-compressed') === 0 ||
            strpos($this->file_type, 'application/x-7z-compressed') === 0) {
            return 'fa-file-archive';
        }
        
        return 'fa-file';
    }
    
    public function isImage()
    {
        return strpos($this->file_type, 'image/') === 0;
    }
    
    public function isPdf()
    {
        return $this->file_type === 'application/pdf';
    }
    
    public function delete()
    {
        // Delete the file from storage
        Storage::disk('public')->delete($this->file_path);
        
        // Delete the database record
        return parent::delete();
    }
}
