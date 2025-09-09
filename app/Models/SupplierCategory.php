<?php

namespace App\Models;

use App\Http\Controllers\SuppliersSubcategoryController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierCategory extends Model
{
    use HasFactory;
    public function subCategories(){
        return $this->hasMany(suppliers_subcategory::class,'category_id');
    }
}
