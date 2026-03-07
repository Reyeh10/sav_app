<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
    'vin',
    'brand',
    'model',
    'model_year',
    'engine',
    'configuration',
    'engine_number',
    'color_exterior',
    'color_interior',
    'arrival_date',
    'mileage',
    'comment',
    'status',
    'sold_price',
     'image',
    'sold_at'
    ];

    /*
    ===============================
       RELATION SALE
    ===============================
    */
    public function sale()
        {
            return $this->hasOne(\App\Models\Sale::class);
        }
}
