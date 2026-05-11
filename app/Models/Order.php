<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'status',
        'subtotal', 'shipping', 'total',
        'shipping_name', 'shipping_address', 'shipping_city',
        'shipping_postal_code', 'shipping_country',
        'tracking_number', 'notes', 'shipped_at',
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'subtotal'   => 'decimal:2',
        'shipping'   => 'decimal:2',
        'total'      => 'decimal:2',
    ];

    // Genera automaticamente il numero ordine
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . strtoupper(uniqid());
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Label leggibili per gli stati
    public function statusLabel(): string
    {
        return match($this->status) {
            'pending'    => 'In attesa',
            'processing' => 'In lavorazione',
            'shipped'    => 'Spedito',
            'delivered'  => 'Consegnato',
            'cancelled'  => 'Annullato',
            'refunded'   => 'Rimborsato',
            default      => $this->status,
        };
    }

    // Colore badge Bootstrap per ogni stato
    public function statusColor(): string
    {
        return match($this->status) {
            'pending'    => 'warning',
            'processing' => 'info',
            'shipped'    => 'primary',
            'delivered'  => 'success',
            'cancelled'  => 'danger',
            'refunded'   => 'secondary',
            default      => 'secondary',
        };
    }

    // Scope filtri
    public function scopePending($q)    { return $q->where('status', 'pending'); }
    public function scopeShipped($q)    { return $q->where('status', 'shipped'); }
    public function scopeProcessing($q) { return $q->where('status', 'processing'); }
}