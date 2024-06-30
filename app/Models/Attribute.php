<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function attributeOption(): HasMany
    {
        return $this->hasMany(AttributeOption::class);
    }
}