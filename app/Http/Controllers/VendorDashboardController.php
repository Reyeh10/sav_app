<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Sale;
use App\Models\Customer;
//use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class VendorDashboardController extends Controller
{
   public function index()
    {
        /* =============================
           PARTIE 1 : KPI
        ============================= */
       /* $totalSold       = Sale::count();
        $stockVehicles   = Vehicle::where('status', 'Disponible')->count();
        $waitingVehicles = Vehicle::where('status', 'En attente')->count(); */
        $totalClients    = Customer::count();


/* =============================
        PARTIE 2 : ANALYSE
============================= */

// Total voitures vendues
$totalSold = \App\Models\Sale::count();

// Stock véhicules
$stockVehicles = \App\Models\Vehicle::where('status','disponible')->count();

// Véhicules en attente
$waitingVehicles = \App\Models\Vehicle::where('status','attente')->count();

// Total clients
$totalClients = \App\Models\Customer::count();

// Ventes par mois
$salesRaw = Sale::selectRaw('MONTH(created_at) as m, COUNT(*) as total')
    ->groupBy('m')
    ->orderBy('m')
    ->pluck('total','m')
    ->toArray();

$salesByMonth = [];

for ($i = 1; $i <= 12; $i++) {
    $salesByMonth[] = $salesRaw[$i] ?? 0;
}

// Arrivées véhicules par mois
$arrivalByMonth = \App\Models\Vehicle::selectRaw('MONTH(arrival_date) as month, COUNT(*) as total')
    ->groupBy('month')
    ->pluck('total','month');

// Flux ventes / arrivées
$salesFlow = [
    'sales' => $salesByMonth,
    'arrivals' => $arrivalByMonth
];

/* =============================
        VENTES PAR MODÈLE
============================= */

$salesByModel = \App\Models\Sale::with('vehicle')
    ->get()
    ->groupBy(function ($sale) {
        return $sale->vehicle->model ?? 'Inconnu';
    })
    ->map(function ($group) {
        return $group->count();
    });

// 🔹 Séparer labels et data pour Chart.js
$salesModelLabels = $salesByModel->keys();
$salesModelData = $salesByModel->values();

        // ✅ véhicules par marque
        $vehiclesByBrand = Vehicle::selectRaw('brand as label, COUNT(*) as total')
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->groupBy('brand')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        /* =============================
           PARTIE 3 : FLUX
        ============================= */

        // ✅ arrivées par mois (12 mois)
        $arrivalRaw = Vehicle::selectRaw('MONTH(arrival_date) as m, COUNT(*) as total')
            ->whereNotNull('arrival_date')
            ->groupBy('m')
            ->orderBy('m')
            ->pluck('total', 'm')
            ->toArray();

        $arrivalByMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $arrivalByMonth[] = $arrivalRaw[$i] ?? 0;
        }

        // ✅ ventes par mois (réutilise)
        $salesFlow = $salesByMonth;

            return view('dashboard.vendor', compact(
            'totalSold',
            'stockVehicles',
            'waitingVehicles',
            'totalClients',
            'salesByMonth',
            'arrivalByMonth',
            'salesFlow',
            'salesModelLabels',
            'salesModelData',
            'vehiclesByBrand'
        ));
    }
}
