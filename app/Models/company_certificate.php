<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Company;

class company_certificate extends Model
{
    use HasFactory;
     protected $fillable = [
        'vendor_id',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'vendor_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'vendor_id', 'vendor_id');
    }
}
