<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'code',
        'status',
        'total_cents',
        'customer_name',
        'email',
        'phone',
    ];

    protected $casts = [
        'total_cents' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Položky objednávky
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Možné stavy objednávky
     */
    public static function statuses(): array
    {
        return [
            'pending'    => 'Čakajúca',
            'confirmed'  => 'Potvrdená',
            'shipped'    => 'Odoslaná',
            'delivered'  => 'Doručená',
            'cancelled'  => 'Zrušená',
        ];
    }

    /**
     * Konverzia total_cents na EUR
     */
    public function getTotalEurAttribute(): float
    {
        return $this->total_cents / 100;
    }

    /**
     * Generovania unique kódu objednávky
     */
    public static function generateCode(): string
    {
        $year = now()->year;
        $lastOrder = static::whereYear('created_at', $year)->latest()->first();
        $number = ($lastOrder ? (int) substr($lastOrder->code, -4) : 0) + 1;
        return sprintf('ORD-%d-%04d', $year, $number);
    }
}

