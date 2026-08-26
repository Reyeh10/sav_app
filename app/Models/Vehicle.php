<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    'sold_at',
    'engine_capacity',
    'fuel_type',
    'doors',
    'cylinders',
    'tire_size',
    'transmission',
    'seats',
    ];

    /*
    ===============================
       RELATION SALE
    ===============================
    */
    /*public function sale()
        {
            return $this->hasOne(\App\Models\Sale::class);
        } */

   public function sale()
    {
        return $this->hasOne(
            \App\Models\Sale::class,
            'vehicle_id',
            'id'
        )->latestOfMany();
    }
    public function proformas(): HasMany
        {
            return $this->hasMany(Proforma::class);
        }
}
