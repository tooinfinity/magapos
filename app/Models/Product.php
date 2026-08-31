<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $guarded = [];

    protected $appends = ['image_path', 'profit'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(Sale::class, 'product_sale', 'product_id', 'sale_id');
    }

    public function purchases(): BelongsToMany
    {
        return $this->belongsToMany(Purchase::class, 'product_purchase', 'product_id', 'purchase_id');
    }

    public function getImagePathAttribute(): string
    {
        return asset('uploads/product_images/' . $this->image);
    }

    public function getProfitAttribute(): float
    {
        return (float) $this->sale_price - (float) $this->purchase_price;
    }
}
