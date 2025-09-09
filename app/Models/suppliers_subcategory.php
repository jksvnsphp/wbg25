<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suppliers_subcategory extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(SupplierCategory::class,'category_id');
    }
    
}
