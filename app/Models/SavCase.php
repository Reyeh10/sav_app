<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavCase extends Model
{
    protected $fillable = [
        'vehicle_id',
        'customer_id',
        'type',
        'description',
        'requires_proforma',
        'status',
        'approved_by'
    ];

    protected $casts = [
        'requires_proforma' => 'boolean'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
