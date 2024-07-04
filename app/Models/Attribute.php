<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(AttributeOption::class, 'attribute_options')
            ->withPivot('value');
    }
}