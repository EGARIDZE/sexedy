<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttributeOption extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'value', 'image_path'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function skus()
    {
        return $this->belongsToMany(Sku::class, 'attribute_option_sku');
    }

    public function images():HasMany
    {
        return $this->hasMany(AttributeOptionImage::class);
    }
}