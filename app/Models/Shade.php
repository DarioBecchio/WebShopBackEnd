<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shade extends Model
{
    protected $fillable = ['name', 'hex_color', 'shade_family_id', 'finish_id'];

    public function family()
    {
        return $this->belongsTo(ShadeFamily::class, 'shade_family_id');
    }

    public function finish()
    {
        return $this->belongsTo(Finish::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}