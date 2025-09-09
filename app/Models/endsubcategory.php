<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class endsubcategory extends Model
{
    use HasFactory;
    public function childCategory(){
        return $this->belongsTo(subcategory::class,'subcategories_id');
    }
}
