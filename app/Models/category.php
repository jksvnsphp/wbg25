<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    public function subcategory()
    {
        return $this->hasMany(subcategory::class);
    }
    public function parentcategory()
    {
        return $this->belongsTo(parent_category::class,'parent_category_id');
    }
    public function category_attributes()
    {
        return $this->hasMany(category_attribute::class,'category_id');
    }
   
}
