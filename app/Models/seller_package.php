<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class seller_package extends Model
{
    use HasFactory;
    public function package(){
        return $this->belongsTo(memberPackage::class,'package_id');
    }
    public function package_services(){
        return $this->hasMany(packageService::class,'package_id');
    }
	public function user()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
