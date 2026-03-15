<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Vehicle;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{

/* ===============================
   FORM CREATION VENTE
=============================== */
public function createWithVehicle(Vehicle $vehicle)
{
    $vehiclesForSale = Vehicle::where('status', 'Disponible')
        ->latest()
        ->get();

    $customers = Customer::latest()->get();

    return view('sales.create', compact('vehicle','vehiclesForSale', 'customers'));
}

public function create()
{
    $vehiclesForSale = Vehicle::where('status', 'Disponible')
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
    // ✅ 1. VALIDATION AVANT TOUT
    // 🔥 Nettoyage AVANT validation
    $cleanPrice = str_replace([' ', ','], ['', '.'], $request->sold_price);

    if (!is_numeric($cleanPrice)) {
        return back()->withErrors([
            'sold_price' => 'Le prix doit être un nombre valide.'
        ])->withInput();
    }

    $price = floatval($cleanPrice);

    // 🔥 Bloquer les montants trop grands AVANT DB
    if ($price <= 0) {
    return back()->withErrors([
        'sold_price' => 'Le prix doit être supérieur à 0.'
    ])->withInput();
}

    // ✅ Maintenant validation normale
    $validated = $request->validate([
        'vehicle_id'   => 'required|exists:vehicles,id',
        'customer_id'  => 'required|exists:customers,id',
        'type_client'  => 'required|in:Particulier,Gouvernement,Para-public,Privee',
        'payment_type' => 'required|in:Cash,Bon de commande,Echeance',
        'sold_price' => 'required|string'
    ]);

    // 🔥 CONVERSION PRIX (on garde ton code)
    $price = str_replace([' ', ','], ['', '.'], $validated['sold_price']);
    $price = floatval($price);

    // ✅ Vérification supplémentaire (sécurité)
    if (!is_numeric($price)) {
        return back()->withErrors([
            'sold_price' => 'Le prix doit être un nombre valide.'
        ])->withInput();
    }

    DB::beginTransaction();

    try {

        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);

        // ✅ Sécurité supplémentaire
        if ($vehicle->status !== 'Disponible') {
            DB::rollBack();
            return back()->withErrors([
                'vehicle_id' => 'Voiture non disponible.'
            ])->withInput();
        }

        // ✅ Création vente (ton code inchangé)
        Sale::create([
            'vehicle_id'   => $vehicle->id,
            'customer_id'  => $validated['customer_id'],
            'sold_by'      => auth()->id(),
            'sold_price'   => $price,
            'payment_type' => $validated['payment_type'],
            'sold_date'    => now(),
        ]);

        // ✅ Mise à jour véhicule
        $vehicle->update([
            'status'  => 'Vendu',
            'sold_at' => now()   // ✅ IMPORTANT
        ]);

        DB::commit();

        return redirect()->route('vehicles.sold')
            ->with('success', 'Voiture vendue.');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->with('error', 'Erreur lors de l\'enregistrement.')
            ->withInput();
    }
}

}
