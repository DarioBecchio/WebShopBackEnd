<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug', 'name', 'country_code', 'description',
        'website_url', 'is_cruelty_free', 'is_vegan',
    ];

    protected $casts = [
        'is_cruelty_free' => 'boolean',
        'is_vegan'        => 'boolean',
    ];

    public function productLines()
    {
        return $this->hasMany(ProductLine::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
