<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inbox extends Model
{
    use HasFactory;
    protected $table = "inbox";
    protected $fillable = ['sender_id', 'receiver_id', 'subject', 'message', 'message_type', 'product_id', 'tender_id'];

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'message_id');
    }

    public function latestChatMessage()
    {
        return $this->hasOne(ChatMessage::class, 'message_id')->latestOfMany();
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function product()
    {
        return $this->belongsTo(products::class, 'product_id');
    }

    public function tender()
    {
        return $this->belongsTo(Tender::class, 'tender_id');
    }
    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }
}
