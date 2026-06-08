<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    protected $fillable = [
        'product_id', 'locale', 'name',
        'description', 'short_description', 'how_to_use',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}