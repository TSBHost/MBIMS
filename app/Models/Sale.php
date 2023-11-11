<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        "customer_id",
        "sale_date",
        "invoice_number",
        "sale_code",
        "total_amount",
        "discount",
        "payable_amount",
        "paid_amount",
        "due_amount",
        "creator",
        "note"
    ];
    public function details()
    {
        return $this->hasMany(SaleDetails::class,'sale_id','id')->with("product","serial");
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}
