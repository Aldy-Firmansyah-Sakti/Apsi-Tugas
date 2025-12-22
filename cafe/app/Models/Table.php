<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nomor_meja',
        'qr_code',
        'status',
        'kapasitas',
    ];

    protected $casts = [
        'kapasitas' => 'integer',
    ];

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function activeOrder()
    {
        return $this->hasOne(Order::class)->whereNotIn('status', ['completed', 'cancelled']);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeOccupied($query)
    {
        return $query->where('status', 'occupied');
    }

    // Helpers
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    public function markAsOccupied()
    {
        $this->update(['status' => 'occupied']);
    }

    public function markAsAvailable()
    {
        $this->update(['status' => 'available']);
    }
}