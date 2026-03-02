<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;

class LogistiqueDashboardController extends Controller
{
    public function index()
{
    $totalVehicles = Vehicle::count();
    $vehiclesEnAttente = Vehicle::where('status', 'En attente')->count();
    $vehiclesEnReparation = Vehicle::where('status', 'En réparation')->count();
    $vehiclesDisponibles = Vehicle::where('status', 'Disponible')->count();

    // ===============================
    // 1️⃣ Voitures par marque
    // ===============================
    $vehiclesByBrand = Vehicle::selectRaw('brand, COUNT(*) as total')
        ->groupBy('brand')
        ->pluck('total', 'brand');

    // ===============================
    // 2️⃣ Voitures par date d'arrivée
    // ===============================
    $vehiclesByDate = Vehicle::selectRaw('arrival_date, COUNT(*) as total')
        ->whereNotNull('arrival_date')
        ->groupBy('arrival_date')
        ->orderBy('arrival_date')
        ->pluck('total', 'arrival_date');

    return view('dashboard.logistique', compact(
        'totalVehicles',
        'vehiclesEnAttente',
        'vehiclesEnReparation',
        'vehiclesDisponibles',
        'vehiclesByBrand',
        'vehiclesByDate'
    ));
}
}
