<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationCategory extends Model
{
    use HasFactory;
    public function subCategories(){
        return $this->hasMany(quotations_subcategory::class,'category_id');
    }
   
}
