<?php
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function products()
    {
    return $this->hasMany(Product::class);
    }
}
