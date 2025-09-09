<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class business_profile_symbol extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'isTradeAssurance',
        'isTrustSeal',
        'isAssessedSupplier',
        'isOnsiteChecked',
        'isProductVerified',
        'isStoreFavorite',
        'isEmailVerified',
        'isCategoryBest',
        'isSecureTransaction',
        'isSupport',
        'isSecurity',
    ];
}
