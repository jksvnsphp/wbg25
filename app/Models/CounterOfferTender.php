<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterOfferTender extends Model
{
    use HasFactory;
    public function tender(){
        return $this->belongsTo(Tender::class,'tender_id');
    }

    public function offer(){
        return $this->belongsTo(OfferTender::class,'offer_id');
    }
}
