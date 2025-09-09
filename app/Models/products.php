<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    public function gallery()
    {
        return $this->hasMany(product_gallery::class, 'product_id');
    }
    public function video()
    {
        return $this->hasOne(product_video::class, 'product_id');
    }
    public function product_attributes()
    {
        return $this->hasMany(product_attribute::class, 'product_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
    public function vendorDetail()
    {
        return $this->belongsTo(company::class, 'vendor_id');
    }
    public function parentcategory()
    {
        return $this->belongsTo(parent_category::class, 'parent_category_id');
    }
    public function category()
    {
        return $this->belongsTo(category::class, 'category_id');
    }
    public function childcategory()
    {
        return $this->belongsTo(subcategory::class, 'subcategory_id');
    }
    public function endchildcategory()
    {
        return $this->belongsTo(endsubcategory::class, 'childcategory_id');
    }
    public function product_setting()
    {
        return $this->hasOne(productSetting::class, 'product_id');
    }
    public function rate_table()
    {
        return $this->belongsTo(shipping_rate_tables::class, 'rate_table_id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'product_id');
    }

}
