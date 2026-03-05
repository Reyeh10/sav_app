<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LogistiqueDashboardController extends Controller
{
    public function index()
    {

        // TOTAL VEHICULES
        $totalVehicles = Vehicle::count();

        // VEHICULES IMPORTES AUJOURD'HUI
       $vehiclesToday = Vehicle::whereDate('arrival_date', today())->count();

        // STATUT
        $vehiclesEnAttente = Vehicle::where('status','En attente')->count();
        $vehiclesEnReparation = Vehicle::where('status','En réparation')->count();
        $vehiclesDisponibles = Vehicle::where('status','Disponible')->count();

        // PAR MARQUE
        $vehiclesByBrand = Vehicle::selectRaw('brand, COUNT(*) as total')
            ->groupBy('brand')
            ->pluck('total','brand');

        return view('dashboard.logistique', compact(
            'totalVehicles',
            'vehiclesToday',
            'vehiclesEnAttente',
            'vehiclesEnReparation',
            'vehiclesDisponibles',
            'vehiclesByBrand'
        ));
    }
}
