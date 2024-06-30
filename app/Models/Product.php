<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{

    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'category_id', 'brand_id'];

    public function offers():HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(ProductDetails::class);
    }

    public function fabrics(): HasMany
    {
        return $this->hasMany(ProductFabric::class);
    }

    public function cares(): HasMany
    {
        return $this->hasMany(ProductCare::class);
    }
}