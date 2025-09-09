<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderCategory extends Model
{
    use HasFactory;
    public function subCategory(){
        return $this->hasMany(tender_subcategory::class,'category_id');
    }
}
