<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'product_id',
        'variant',
        'quantity',
        'price',
        'qtyPrice',
    ];

    protected $casts = [
        'variant' => 'array',
    ];
    public function product(){
        return $this->belongsTo(products::class,'product_id');
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'product_id');
    }
}
