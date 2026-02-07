<?php

namespace App\Http\Controllers;
use App\Models\Warranty;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    public function showByVehicle($vehicleId)
    {
        return Warranty::where('vehicle_id', $vehicleId)->firstOrFail();
    }
}
