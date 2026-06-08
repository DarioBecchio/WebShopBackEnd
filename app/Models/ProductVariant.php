<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id', 'shade_id', 'size_id', 'sku',
        'price', 'currency', 'stock_qty', 'is_default',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'is_default' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function shade()
    {
        return $this->belongsTo(Shade::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'product_ingredients')
                    ->withPivot('position', 'is_key_ingredient')
                    ->orderByPivot('position');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'variant_id')->orderBy('sort_order');
    }

    public function packaging()
    {
        return $this->hasOne(Packaging::class, 'variant_id');
    }
}