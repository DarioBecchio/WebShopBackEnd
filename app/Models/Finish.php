<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finish extends Model
{
    protected $fillable = ['code', 'label'];

    public function shades()
    {
        return $this->hasMany(Shade::class);
    }
}
