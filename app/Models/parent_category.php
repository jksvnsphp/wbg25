<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class parent_category extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->hasMany(category::class, 'parent_category_id');
    }
    public function subcategory()
    {
        return $this->hasMany(category::class, 'parent_category_id');
    }
    
}
