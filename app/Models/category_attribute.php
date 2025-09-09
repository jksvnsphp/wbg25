<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category_attribute extends Model
{
    use HasFactory;

    public function attribute(){
        return $this->belongsTo(attribute::class,'attribute_id');
    }
}
