<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'inci_name', 'common_name', 'function_description',
        'is_allergen', 'is_endocrine_disruptor',
    ];

    protected $casts = [
        'is_allergen'            => 'boolean',
        'is_endocrine_disruptor' => 'boolean',
    ];

    public function variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_ingredients')
                    ->withPivot('position', 'is_key_ingredient');
    }
}