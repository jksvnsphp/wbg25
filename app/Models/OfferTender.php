<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferTender extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'vendor_id',
        'tender_id',
        'offer_price',
        'status',
    ];
    
    public function tender(){
        return $this->belongsTo(Tender::class,'tender_id');
    }
    
    public function sender(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'vendor_id');
    }
    
    public function counters()
    {
        return $this->hasMany(CounterOfferTender::class, 'offer_id');
    }
     
}
