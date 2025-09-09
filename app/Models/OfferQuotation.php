<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferQuotation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'vendor_id',
        'quotation_id',
        'offer_price',
        'status',
    ];
    public function quotation(){
        return $this->belongsTo(Quotation::class,'quotation_id');
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
        return $this->hasMany(CounterOfferQuotation::class, 'quote_id');
    }
}
