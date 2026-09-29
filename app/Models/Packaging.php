<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    protected $table = 'packaging';

    protected $fillable = [
        'variant_id',
        'material_type',
        'is_recyclable',
        'is_refillable',
        'weight_grams',
        'country_of_origin',
    ];

    protected $casts = [
        'is_recyclable' => 'boolean',
        'is_refillable' => 'boolean',
        'weight_grams'  => 'decimal:2',
    ];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}