<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public static function generateOrderNumber()
    {
        $prefix = 'ORD-';
        $uniqueId = str_pad(Order::max('id') + 1, 8, '0', STR_PAD_LEFT); 
        return $prefix . $uniqueId;
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class,'order_id');
    }
}
