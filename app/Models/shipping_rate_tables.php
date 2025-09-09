<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shipping_rate_tables extends Model
{
    use HasFactory;
    public function shipping_rate_costs(){
        return $this->hasMany(shipping_rate_cost::class,'shipping_rate_id');
    }
}
