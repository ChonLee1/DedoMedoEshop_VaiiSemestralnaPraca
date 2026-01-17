<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'unit_price_cents',
    ];

    protected $casts = [
        'qty' => 'integer',
        'unit_price_cents' => 'integer',
    ];

    /**
     * Objednávka ku ktorej patrí táto položka
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Produkt v tejto položke objednávky
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Výpočet celkovej ceny položky
     */
    public function getTotalPriceAttribute(): int
    {
        return $this->qty * $this->unit_price_cents;
    }
}

