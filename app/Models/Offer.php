<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'name', 'code', 'price', 'discount'];

    public static function generateUniqueCode()
    {
        do {
            $code = Str::upper(Str::random(10));
        } while (Offer::where('code', $code)->exists());

        return $code;
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_options', 'offer_id', 'attribute_id')->withPivot('value');
    }
}