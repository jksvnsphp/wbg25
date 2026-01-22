<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    public function vendor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendorDetail()
    {
        return $this->belongsTo(company::class, 'user_id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    public function offerTender()
    {
        return $this->belongsTo(OfferTender::class, 'offer_tender_id');
    }

    public function offerQuotation()
    {
        return $this->belongsTo(OfferQuotation::class, 'offer_quotation_id');
    }
}
