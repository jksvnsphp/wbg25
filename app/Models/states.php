<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class states extends Model
{
    use HasFactory;
    public function country()
    {
        return $this->belongsTo(countries::class,'country_id');
    }

    public function cities()
    {
        return $this->hasMany(cities::class,'state_id');
    }
}
