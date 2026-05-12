<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactMessage extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'type',
        'subject', 'message', 'status',
        'admin_reply', 'read_at', 'resolved_at',
    ];

    protected $casts = [
        'read_at'      => 'datetime',
        'resolved_at'  => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function typeLabel(): string
    {
        return match($this->type) {
            'complaint' => 'Reclamo',
            'return'    => 'Richiesta reso',
            'info'      => 'Informazioni',
            'order'     => 'Problema ordine',
            'other'     => 'Altro',
            default     => $this->type,
        };
    }

    public function typeColor(): string
    {
        return match($this->type) {
            'complaint' => 'danger',
            'return'    => 'warning',
            'info'      => 'info',
            'order'     => 'primary',
            'other'     => 'secondary',
            default     => 'secondary',
        };
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'new'         => 'Nuovo',
            'in_progress' => 'In gestione',
            'resolved'    => 'Risolto',
            default       => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'new'         => 'danger',
            'in_progress' => 'warning',
            'resolved'    => 'success',
            default       => 'secondary',
        };
    }

    public function scopeNew($q)        { return $q->where('status', 'new'); }
    public function scopeInProgress($q) { return $q->where('status', 'in_progress'); }
    public function scopeResolved($q)   { return $q->where('status', 'resolved'); }
}