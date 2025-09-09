<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shipping_rate_cost extends Model
{
    use HasFactory;
    protected $fillable = [
        'shipping_rate_id',
        'shipping_service',
        'shipping_type',
        'cost'
    ];
    public function shipping_regions(){
        return $this->hasMany(shipping_rate_cost_region::class,'shipping_rate_cost_id');
    }
}
