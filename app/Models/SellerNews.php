<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerNews extends Model
{
    use HasFactory;
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'vendor_id');
    }
}
