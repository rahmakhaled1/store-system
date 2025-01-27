<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        "code", "status", "total", "username", "governorate_id", "phone", "email", "total_before_delivery", "total_after_delivery", "address", "city"
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
}
