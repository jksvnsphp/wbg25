<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shipping_rate_cost_region extends Model
{
    use HasFactory;
    protected $fillable = [
        'shipping_rate_cost_id',
        'region_id',
    ];

    public function country()
    {
        return $this->belongsTo(countries::class, 'country_id');
    }

    public function region()
    {
        return $this->belongsTo(region::class, 'region_id');
    }
}
