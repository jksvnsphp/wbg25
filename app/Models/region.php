<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class region extends Model
{
    use HasFactory;
    public function countries(){
        return $this->hasMany(countries::class,'region_id')->where('status',1);
    }
}
