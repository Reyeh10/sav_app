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
        'image',
        'color_exterior',
        'color_interior',
        'year',
        'arrival_date',
        'mileage',
        'status',
        'comment',
        'sold_price'
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
