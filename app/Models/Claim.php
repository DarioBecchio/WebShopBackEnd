<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $fillable = ['code', 'label', 'category'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_claims');
    }
}