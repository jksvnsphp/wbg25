<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;
    public function parentcategory(){
        return $this->belongsTo(parent_category::class,'parent_category_id');
    }
    public function category(){
        return $this->belongsTo(category::class,'category_id');
    }
    public function childcategory(){
        return $this->belongsTo(subcategory::class,'subcategory_id');
    }
    public function endchildcategory(){
        return $this->belongsTo(endsubcategory::class,'childcategory_id');
    }

    public function tender_setting(){
        return $this->hasOne(tender_setting::class,'tendor_id');
    }
    public function rate_table(){
        return $this->belongsTo(shipping_rate_tables::class,'rate_table_id');
    }
    public function vendor(){
        return $this->belongsTo(User::class,'vendor_id');

    }
}
