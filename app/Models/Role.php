<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'permissions'];

    protected $casts = [
        'permissions' => 'array',
    ];

    /**
     * Get the users that belong to this role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Check if the role has a specific permission.
     */
    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions ?? []);
    }
}
