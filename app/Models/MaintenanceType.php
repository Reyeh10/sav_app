<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceType extends Model
{
    protected $fillable = [
        'name',
        'interval_km',
        'interval_days'
    ];

    public function maintenanceRecords()
    {
        return $this->hasMany(MaintenanceRecord::class);
    }

   /* public function reminders()
    {
        return $this->hasMany(MaintenanceReminder::class);
    }*/
}
