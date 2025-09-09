<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attribute extends Model
{
    use HasFactory;
    public function attribute_options(){
        return $this->hasMany(AttributeItem::class,'attribute_id','id');
    }
    public function items(){
        return $this->hasMany(AttributeItem::class,'attribute_id','id');
    }
}
