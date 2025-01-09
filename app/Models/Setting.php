<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ["governorate_id", "delivery"];

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
}
