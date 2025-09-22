<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class company extends Model
{
    use HasFactory; 

    public function user()
    {
       return $this->belongsTo(User::class, 'vendor_id', 'id');
    }

    public function certificates()
    {
        return $this->hasMany(company_certificate::class, 'vendor_id', 'vendor_id');
    } 

}
