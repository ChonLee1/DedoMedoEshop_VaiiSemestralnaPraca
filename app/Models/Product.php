<?php
class Prouct extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','name','description','price',
        'stock','category_id','harvest_batch_id','created_at','updated_at'
    ];


}
