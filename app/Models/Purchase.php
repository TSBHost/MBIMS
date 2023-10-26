<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        "supplier_id",
        "purchase_date",
        "invoice_number",
        "purchase_code",
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
        return $this->hasMany(PurchaseDetails::class,'purchase_id','id')->with("product","serial");
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }
}
