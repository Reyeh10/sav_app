<?php

namespace App\Http\Controllers;
use App\Models\MaintenanceType;
use Illuminate\Http\Request;

class MaintenanceTypeController extends Controller
{
    public function index()
    {
        return MaintenanceType::all();
    }

    public function store(Request $request)
    {
        return MaintenanceType::create($request->all());
    }
}
