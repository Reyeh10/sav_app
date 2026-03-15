<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Sale;
use App\Models\Customer;
//use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        /* =============================
           PARTIE 1 : KPI
        ============================= */
       /* $totalSold       = Sale::count();
        $stockVehicles   = Vehicle::where('status', 'Disponible')->count();
        $waitingVehicles = Vehicle::where('status', 'En attente')->count();
        $totalClients    = Customer::count();*/

        // Total voitures vendues
        $totalSold = Sale::count();

        // Stock véhicules
        $stockVehicles = Vehicle::where('status','Disponible')->count();

        // Véhicules en attente
        $waitingVehicles = Vehicle::where('status','En attente')->count();

        // Total clients
        $totalClients = Customer::count();

/* =============================
        PARTIE 2 : ANALYSE
============================= */

// Total voitures vendues
$totalSold = \App\Models\Sale::count();

// Stock véhicules
$stockVehicles = \App\Models\Vehicle::where('status','Disponible')->count();

// Véhicules en attente
$waitingVehicles = \App\Models\Vehicle::where('status','En attente')->count();

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
        PARTIE 3 : FLUX DES VÉHICULES
        ============================= */

        $year = request('year', date('Y'));

        /* ARRIVÉES */
        $arrivalRawFlow = Vehicle::selectRaw('MONTH(arrival_date) as m, COUNT(*) as total')
            ->whereNotNull('arrival_date')
            ->whereYear('arrival_date', $year)
            ->groupBy('m')
            ->pluck('total','m')
            ->toArray();

        $arrivalByMonth = [];

        for ($i=1;$i<=12;$i++){
            $arrivalByMonth[] = $arrivalRawFlow[$i] ?? 0;
        }


        /* VENTES */
        $salesRawFlow = Vehicle::selectRaw('MONTH(sold_at) as m, COUNT(*) as total')
            ->where('status','Vendu')
            ->whereNotNull('sold_at')
            ->whereYear('sold_at',$year)
            ->groupBy('m')
            ->pluck('total','m')
            ->toArray();

        $salesByMonth = [];

        for ($i=1;$i<=12;$i++){
            $salesByMonth[] = $salesRawFlow[$i] ?? 0;
        }

        /* =============================
        PARTIE 4 : REVENUS
        ============================= */



            // Chiffre d'affaires total
            $totalRevenue = Sale::sum('sold_price');

            // Revenus ce mois
            $revenueThisMonth = Sale::whereMonth('created_at', now()->month)
                                    ->sum('sold_price');

            // Prix moyen
            $averageSalePrice = Sale::avg('sold_price');

            // Meilleure vente
            $maxSalePrice = Sale::max('sold_price');


        /* =============================
                PARTIE 5 : TOP VOITURES VENDUES
        ============================= */

        $topVehicles = Sale::with('vehicle')
            ->selectRaw('vehicle_id, COUNT(*) as total')
            ->groupBy('vehicle_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();


            /* =============================
                    PARTIE 6 : STOCK PAR MARQUE
            ============================= */

        $stockByBrand = Vehicle::selectRaw('brand, COUNT(*) as total')
            ->where('status','Disponible')
            ->whereNotNull('brand')
            ->groupBy('brand')
            ->orderByDesc('total')
            ->get();

            /* =============================
        RETURN VIEW
        ============================= */

            return view('dashboard.admindashboard', compact(
            'totalSold',
            'stockVehicles',
            'waitingVehicles',
            'totalClients',
            'salesByMonth',
            'arrivalByMonth',
            'salesFlow',
            'salesModelLabels',
            'salesModelData',
            'vehiclesByBrand',

            // PARTIE 4
            'totalRevenue',
            'revenueThisMonth',
            'averageSalePrice',
            'maxSalePrice',

            // PARTIE 5
            'topVehicles',

            // PARTIE 6
            'stockByBrand'
        ));
    }
}

