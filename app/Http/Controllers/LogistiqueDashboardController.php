<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Carbon\Carbon;

class LogistiqueDashboardController extends Controller
{
    public function index()
    {
        $totalVehicles = Vehicle::count();
        $vehiclesEnAttente = Vehicle::where('status', 'En attente')->count();
        $vehiclesEnReparation = Vehicle::where('status', 'En réparation')->count();
        $vehiclesDisponibles = Vehicle::where('status', 'Disponible')->count();

        // ✅ Véhicules importés aujourd'hui
        $vehiclesToday = Vehicle::whereDate('arrival_date', Carbon::today())->count();

        // Graph marque
        $vehiclesByBrand = Vehicle::selectRaw('brand, COUNT(*) as total')
            ->groupBy('brand')
            ->pluck('total','brand');

        // Graph date
        $vehiclesByMonthRaw = Vehicle::selectRaw('MONTH(arrival_date) as m, COUNT(*) as total')
            ->whereNotNull('arrival_date')
            ->groupBy('m')
            ->orderBy('m')
            ->pluck('total','m')
            ->toArray();

$vehiclesByMonth = [];

for ($i = 1; $i <= 12; $i++) {
    $vehiclesByMonth[] = $vehiclesByMonthRaw[$i] ?? 0;
}

        return view('dashboard.logistique', compact(
            'totalVehicles',
            'vehiclesEnAttente',
            'vehiclesEnReparation',
            'vehiclesDisponibles',
            'vehiclesToday',
            'vehiclesByBrand',
            'vehiclesByMonth'
        ));
    }
}
