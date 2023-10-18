<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "code",
        "description",
        "category_id",
        "brand_id",
        "unit_id",
        "image",
        "is_active",
        "creator"
    ];

    public function category() {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function brand() {
        return $this->belongsTo(Brand::class,'brand_id','id');
    }
    public function unit() {
        return $this->belongsTo(Unit::class,'unit_id','id');
    }
}
