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
    try {

        Log::info('SALE REQUEST DATA', $request->all());

        $validated = $request->validate([
            'vehicle_id'  => 'required|exists:vehicles,id',
            'customer_id' => 'nullable|exists:customers,id',
            'type_client' => 'required|in:Particulier,Gouvernement,Para-public,Privee',
            'payment_type' => 'required|in:Cash,Bon de commande,Echeance',
            'customer_name' => 'nullable|string|max:255',
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

        // 🔥 CORRECTION MAJEURE ICI
        if ($vehicle->status !== 'Disponible') {
            return back()->with('error', 'Cette voiture n’est plus disponible.');
        }

        /* ===== GESTION CLIENT ===== */
        $customerId = $validated['customer_id'];

        if (!$customerId && $request->filled('customer_name')) {

            $customer = Customer::where('name', $request->customer_name)->first();

            if (!$customer) {
                $customer = Customer::create([
                    'name'        => $request->customer_name,
                    'type_client' => $validated['type_client'],
                ]);
            }

            $customerId = $customer->id;
        }

        if (!$customerId) {
            return back()->with('error', 'Veuillez sélectionner ou saisir un client.');
        }

        /* ===== CREATE SALE ===== */
        $sale = Sale::create([
            'vehicle_id'   => $vehicle->id,
            'customer_id'  => $customerId,
            'sold_by'      => auth()->id(),
            'sold_price'   => $price,
            'payment_type' => $validated['payment_type'],
            'sold_date'    => now(),
        ]);

        /* ===== UPDATE VEHICLE ===== */
        $vehicle->update([
            'status'     => 'Vendu',   // 🔥 cohérent avec ton système
            'sold_price' => $price,
            'sold_at'    => now(),
        ]);

        DB::commit();

        return redirect()
            ->route('vehicles.sold')
            ->with('success', 'Voiture vendue avec succès.');

    } catch (\Exception $e) {

        DB::rollBack();

        Log::error('SALE STORE ERROR => ' . $e->getMessage());
        Log::error('SALE STORE TRACE => ' . $e->getTraceAsString());

        return back()->with('error', 'Erreur lors de l’enregistrement.');
    }
}

}
