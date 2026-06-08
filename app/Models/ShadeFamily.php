<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShadeFamily extends Model
{
    protected $fillable = ['name', 'hex_swatch'];

    public function shades()
    {
        return $this->hasMany(Shade::class);
    }
}