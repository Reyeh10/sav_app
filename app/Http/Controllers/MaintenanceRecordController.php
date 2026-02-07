<?php

namespace App\Http\Controllers;
use App\Models\MaintenanceRecord;
use Illuminate\Http\Request;

class MaintenanceRecordController extends Controller
{
    public function store(Request $request)
    {
        return MaintenanceRecord::create($request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'maintenance_type_id' => 'required|exists:maintenance_types,id',
            'done_at' => 'required|date',
            'mileage' => 'required|integer',
        ]));
    }
}
