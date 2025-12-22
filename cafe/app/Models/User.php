<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Scopes
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeStaff($query)
    {
        return $query->where('role', 'staff');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helpers
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }
}