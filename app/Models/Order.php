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

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

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

    public function getTotalEurAttribute(): float
    {
        return $this->total_cents / 100;
    }

    public static function generateCode(): string
    {
        $year = now()->year;
        $lastOrder = static::whereYear('created_at', $year)->latest()->first();
        $number = ($lastOrder ? (int) substr($lastOrder->code, -4) : 0) + 1;
        return sprintf('ORD-%d-%04d', $year, $number);
    }
}

