<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class countries extends Model
{
    use HasFactory;
    public function states()
    {
        return $this->hasMany(states::class,'country_id');
    }
}
