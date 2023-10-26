<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        "purchase_id",
        "product_id",
        "purchase_price",
        "quantity",
        "total_amount",
        "warranty_info",
        "creator",
        "note"
    ];

    public function serial()
    {
        return $this->hasMany(ProductSerial::class,"purchase_details_id","id");
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class,"product_id","id")->with("category","brand","unit");
    }
}
