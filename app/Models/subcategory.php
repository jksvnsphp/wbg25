<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subcategory extends Model
{
    use HasFactory;
    public function endsubcategories(){
        return $this->hasMany(endsubcategory::class,'subcategories_id');
    }
    public function subcategory(){
        return $this->hasMany(endsubcategory::class,'subcategories_id');
    }
    public function category(){
        return $this->belongsTo(category::class,'category_id');
    }
}
