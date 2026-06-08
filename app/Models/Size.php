<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = ['amount', 'unit', 'display_label'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}