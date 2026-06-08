<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sku', 'slug', 'brand_id', 'product_line_id',
        'category_id', 'skin_type_id', 'is_active', 'launched_at',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'launched_at' => 'datetime',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function productLine()
    {
        return $this->belongsTo(ProductLine::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function skinType()
    {
        return $this->belongsTo(SkinType::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function claims()
    {
        return $this->belongsToMany(Claim::class, 'product_claims');
    }

    public function certifications()
    {
        return $this->belongsToMany(Certification::class, 'product_certifications')
                    ->withPivot('certified_at', 'expires_at');
    }

    public function skinConcerns()
    {
        return $this->belongsToMany(SkinConcern::class, 'product_skin_concerns');
    }

    public function getNameAttribute(): string
    {
        return $this->translations->firstWhere('locale', 'it')?->name
            ?? $this->translations->first()?->name
            ?? $this->sku;
    }
}
