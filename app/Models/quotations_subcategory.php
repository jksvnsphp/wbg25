<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quotations_subcategory extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(QuotationCategory::class,'category_id');
    }
}
