<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = ['code', 'name', 'issuing_body', 'logo_url'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_certifications')
                    ->withPivot('certified_at', 'expires_at');
    }
}