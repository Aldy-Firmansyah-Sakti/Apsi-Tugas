<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'metode',
        'amount',
        'status',
        'transaction_id',
        'qris_url',
        'response_data',
        'expired_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'response_data' => 'array',
        'expired_at' => 'datetime',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Scopes
    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Helpers
    public function isSuccess()
    {
        return $this->status === 'success';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isExpired()
    {
        return $this->expired_at && $this->expired_at->isPast();
    }
}