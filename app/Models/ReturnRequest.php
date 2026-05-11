<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnRequest extends Model
{
    protected $fillable = [
        'user_id', 'order_id', 'order_number', 'status',
        'reason', 'description', 'admin_notes',
        'refund_amount', 'resolved_at',
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2',
        'resolved_at'   => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'pending'   => 'In attesa',
            'approved'  => 'Approvato',
            'rejected'  => 'Rifiutato',
            'completed' => 'Completato',
            default     => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'pending'   => 'warning',
            'approved'  => 'success',
            'rejected'  => 'danger',
            'completed' => 'primary',
            default     => 'secondary',
        };
    }

    public function reasonLabel(): string
    {
        return match($this->reason) {
            'damaged'            => 'Prodotto danneggiato',
            'wrong_item'         => 'Articolo sbagliato',
            'not_as_described'   => 'Non corrisponde alla descrizione',
            'changed_mind'       => 'Cambiato idea',
            'other'              => 'Altro',
            default              => $this->reason,
        };
    }

    public function scopePending($q)  { return $q->where('status', 'pending'); }
    public function scopeApproved($q) { return $q->where('status', 'approved'); }
    public function scopeRejected($q) { return $q->where('status', 'rejected'); }
}