<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'type',
        'recipient',
        'subject',
        'status',
        'notes',
    ];

    // Scope per tipo
    public function scopeNewsletter($query)
    {
        return $query->where('type', 'newsletter');
    }

    public function scopeTransactional($query)
    {
        return $query->where('type', '!=', 'newsletter');
    }
}