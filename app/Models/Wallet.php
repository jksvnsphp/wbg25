<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
      public function vendor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function vendorDetail()
    {
        return $this->belongsTo(company::class, 'user_id');
    }
}
