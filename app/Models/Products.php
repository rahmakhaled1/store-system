<?php

namespace App\Models;

use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Products extends Model
{
    use HasFactory, SearchTrait;

    protected $table = 'products';
    protected $fillable = [
        "name", "section", "code", "price_after_discount", "price_before_discount", "description", "status", "image"
    ];
     protected $searchable  =["name", "code"];

     public function imageLink() :Attribute
     {
        return Attribute::make(
            get: fn() => $this->image ? url("uploads/"."$this->image") : '',
     );
     }

     public function orderItem()
     {
            return $this->hasMany(OrderItem::class);
     }
}
