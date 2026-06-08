<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkinConcern extends Model
{
    protected $fillable = ['code', 'label', 'description'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_skin_concerns');
    }
}