<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /* public function savCases()
    {
        return $this->hasMany(SavCase::class);
    }

   public function maintenanceReminders()
    {
        return $this->hasMany(MaintenanceReminder::class);
    }*/
}
