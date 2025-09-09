<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomeCategory extends Model
{
    use HasFactory;
    protected $table = 'category';
    public $timestamps = false;
    protected $fillable = ['category_name', 'parent_id', 'category_icon','classified_image','title','keyword','description']; 
}
