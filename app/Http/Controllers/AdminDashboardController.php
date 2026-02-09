<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ===== BASIC COUNTS =====
        $totalVehicles = Vehicle::count();
        $totalClients = Customer::count();

        $activeVehicles = Vehicle::where('status', 'active')->count();

        $newClients = Customer::whereDate(
            'created_at',
            '>=',
            now()->subDays(30)
        )->count();

        // ===== STATUS COUNTS =====
        $soldVehicles = Vehicle::where('status', 'sold')->count();
        $approvedVehicles = Vehicle::where('status', 'approved')->count();
        $rejectedVehicles = Vehicle::where('status', 'rejected')->count();

        // ===== VEHICLES BY BRAND =====
        $vehiclesByBrand = Vehicle::select(
                'brand',
                DB::raw('count(*) as total')
            )
            ->groupBy('brand')
            ->get();

        // ===== SOLD VEHICLES BY MONTH =====
        $soldByMonth = Vehicle::select(
                DB::raw('MONTH(sold_at) as month'),
                DB::raw('count(*) as total')
            )
            ->where('status', 'sold')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        // ⭐ IMPORTANT — VOITURES NON VENDUES
        $notSoldVehicles = Vehicle::where('status', '!=', 'sold')->count();

        return view('dashboard.admindashboard', compact(
            'totalVehicles',
            'totalClients',
            'activeVehicles',
            'newClients',
            'soldVehicles',
            'approvedVehicles',
            'rejectedVehicles',
            'notSoldVehicles',   // ⭐ OBLIGATOIRE
            'vehiclesByBrand',
            'soldByMonth'
        ));
    }
}
