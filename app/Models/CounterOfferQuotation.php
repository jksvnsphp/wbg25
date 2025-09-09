<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterOfferQuotation extends Model
{
    use HasFactory;
    
    public function quotation(){
        return $this->belongsTo(Quotation::class,'quotation_id');
    }

    public function offer(){
        return $this->belongsTo(OfferQuotation::class,'quote_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
