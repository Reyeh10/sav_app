<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Vehicle;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{

/* ===============================
   FORM CREATION VENTE
=============================== */
public function create()
{
    $vehiclesForSale = Vehicle::where('status', 'approved')
        ->latest()
        ->get();

    $customers = Customer::latest()->get();

    return view('sales.create', compact('vehiclesForSale', 'customers'));
}


/* ===============================
   ENREGISTRER VENTE
=============================== */
public function store(Request $request)
{
    try {

        /* ===== DEBUG LOG ===== */
        Log::info('SALE REQUEST DATA', $request->all());

        /* ===== VALIDATION ===== */
        $validated = $request->validate([
            'vehicle_id'  => 'required|exists:vehicles,id',
            'customer_id' => 'required|exists:customers,id',
            'sold_price'  => 'required'
        ]);

        /* ===== CONVERT PRIX ===== */
        $price = floatval(str_replace(',', '', $request->sold_price));

        if ($price <= 0) {
            return back()->with('error', 'Le prix doit être supérieur à 0');
        }

        DB::beginTransaction();

        /* ===== VEHICLE ===== */
        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);

        if ($vehicle->status !== 'approved') {
            return back()->with('error', 'Cette voiture n’est plus disponible.');
        }

        /* ===== CREATE SALE ===== */
        $sale = Sale::create([
            'vehicle_id'  => $vehicle->id,
            'customer_id' => $validated['customer_id'],
            'sold_by'     => auth()->id(),
            'sold_price'  => $price,
            'sold_date'   => now(),
        ]);

        /* ===== UPDATE VEHICLE ===== */
        $vehicle->update([
            'status' => 'sold'
        ]);

        DB::commit();

        return redirect()
            ->route('vehicles.sold')
            ->with('success', 'Voiture vendue avec succès.');

    } catch (\Exception $e) {

        DB::rollBack();

        Log::error('SALE STORE ERROR => ' . $e->getMessage());

        return back()->with('error', 'Erreur lors de l’enregistrement.');
    }
}

}
