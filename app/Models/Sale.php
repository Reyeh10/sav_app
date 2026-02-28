<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\User;

class Sale extends Model
{

     use HasFactory;
    protected $fillable = [
        'vehicle_id',
        'customer_id',
        'sold_by',
        'sold_price',
        'sold_date',
         'payment_type',
    ];

    protected $casts = [
        'sold_date' => 'datetime',
        //'sold_price' => 'float'
         'sold_price' => 'decimal:2',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'sold_by');
    }
}
