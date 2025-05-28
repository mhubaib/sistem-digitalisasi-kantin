<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'stock',
        'category',
        'description',
        'image',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::disk('public')->url($this->image);
        }

        return null;
    }

    /**
     * Check if product has image
     */
    public function hasImage()
    {
        return !empty($this->image) && Storage::disk('public')->exists($this->image);
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Check if product is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if product is out of stock
     */
    public function isOutOfStock()
    {
        return $this->stock <= 0;
    }

    /**
     * Check if product has low stock
     */
    public function hasLowStock($threshold = 5)
    {
        return $this->stock > 0 && $this->stock <= $threshold;
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for products in stock
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope for products by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
