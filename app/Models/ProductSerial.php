<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSerial extends Model
{
    use HasFactory;
    protected $fillable = [
        "purchase_id",
        "purchase_details_id",
        "product_id",
        "serial_number",
        "is_sold",
        "sale_id",
        "sale_details_id",
        "creator",
        "note"
    ];
}
