<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HarvestBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'location',
        'brix',
        'harvested_at',
    ];

    protected $casts = [
        'harvested_at' => 'date',
        'brix' => 'float',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getDisplayNameAttribute(): string
    {
        return "{$this->year} - {$this->location}";
    }
}

