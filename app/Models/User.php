<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\countries;
use App\Models\company;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function countryData()
    {
        return $this->belongsTo(countries::class, 'country');
    }

    public function stateData()
    {
        return $this->belongsTo(states::class, 'state');
    }

    public function company()
    {
        return $this->hasOne(company::class, 'vendor_id');
    }

    public function exports()
    {
        return $this->hasOne(export_region::class, 'vendor_id');
    }
    public function social()
    {
        return $this->hasOne(social_media::class, 'vendor_id');
    }
    public function symbols()
    {
        return $this->hasOne(business_profile_symbol::class, 'vendor_id');
    }
    public function products()
    {
        return $this->hasMany(products::class, 'vendor_id', 'id');
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'vendor_id');
    }
    public function sellerPackage()
    {
        return $this->hasMany(seller_package::class, 'seller_id');
    }
    public function sellerPackageOne()
    {
        return $this->hasOne(seller_package::class, 'seller_id');
    }
    public function payment_info()
    {
        return $this->hasOne(bank_details::class, 'vendor_id');
    }
    public function payment_infos()
    {
        return $this->hasMany(bank_details::class, 'vendor_id');
    }
    public function store_meta()
    {
        return $this->hasOne(MetaData::class, 'user_id');
    }
    public function profile_meta()
    {
        return $this->hasOne(ProfileMetaData::class, 'user_id');
    }
    public function store_keys()
    {
        return $this->hasOne(StoreSearchKey::class, 'user_id');
    }

    public function certificates()
    {
        return $this->hasMany(company_certificate::class, 'vendor_id');
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
}
