<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vin',
        'plate_number',
        'brand',
        'model',
        'model_year',
        'image',
        'color_exterior',
        'color_interior',
       // 'year',
        'engine',
        'configuration',
        'engine_number',
        'arrival_date',
        'mileage',
        'status',
        'comment',
        'sold_price',
        'sold_at'
    ];

    /*
    ===============================
       RELATION SALE
    ===============================
    */
    public function sale()
    {
        return $this->hasOne(Sale::class);
    }
}
