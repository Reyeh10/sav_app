<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
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
    'status'

];

    /* Relations */
    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }

    /* public function warranty()
    {
        return $this->hasOne(Warranty::class);
    }

    public function maintenanceRecords()
    {
        return $this->hasMany(MaintenanceRecord::class);
    }

    public function maintenanceReminders()
    {
        return $this->hasMany(MaintenanceReminder::class);
    }

    public function savCases()
    {
        return $this->hasMany(SavCase::class);
    }*/

    public function sale()
    {
        return $this->hasOne(Sale::class);
    }
}
