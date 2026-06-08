<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkinType extends Model
{
    protected $fillable = ['code', 'label'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}