<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\User;


class Inspection extends Model
{
    protected $fillable = [
        'vehicle_id',
        'inspector_id',
        'mechanical_state',
        'body_state',
        'interior_state',
        'compliance',
        'status',
        'report_path',
        'inspected_at'
    ];

    protected $casts = [
        'compliance' => 'boolean',
        'inspected_at' => 'datetime'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
}

