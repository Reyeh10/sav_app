<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\User;

class VendorDashboardController extends Controller
{
    public function index()
    {
        // ✅ TOTAL VOITURES
        $totalVehicles = Vehicle::count();

        // ✅ VOITURES VENDUES
        $soldVehicles = Vehicle::where('status', 'sold')->count();

        // ✅ VOITURES APPROUVÉES
        $approvedVehicles = Vehicle::where('status', 'approved')->count();

        // ✅ VOITURES NON VENDUES
        $notSoldVehicles = Vehicle::where('status', '!=', 'sold')->count();

        // ✅ TOTAL CLIENTS
        $totalClients = Customer::count();

        // ✅ TOTAL EMPLOYÉS
        $totalEmployees = User::count();

        return view('dashboard.vendor', compact(
            'totalVehicles',
            'soldVehicles',
            'approvedVehicles',
            'notSoldVehicles',
            'totalClients',
            'totalEmployees'
        ));
    }
}
