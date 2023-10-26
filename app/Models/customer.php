<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "contact_person",
        "address",
        "phone",
        "email",
        "description",
        "is_active",
        "creator"
    ];
}
