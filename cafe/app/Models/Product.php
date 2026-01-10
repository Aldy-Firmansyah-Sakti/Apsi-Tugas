<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'nama',
        'slug',
        'deskripsi',
        'harga',
        'foto',
        'is_available',
        'stock',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'is_available' => 'boolean',
        'stock' => 'integer',
    ];

    protected $appends = ['formatted_price'];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->harga ?? 0, 0, ',', '.');
    }

    public function getImageUrlAttribute()
    {
        return get_product_image_url($this->foto) ?: get_default_product_image();
    }

    public function getHasImageAttribute()
    {
        return !empty($this->foto);
    }

    // Mutators
    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}