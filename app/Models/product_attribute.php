<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_attribute extends Model
{
    use HasFactory;
    public function categoryAttribute(){
        return $this->belongsTo(category_attribute::class,'attribute_id','id');
    }
}
