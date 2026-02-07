<?php

namespace App\Http\Controllers;
use App\Models\Sale;
use App\Models\Warranty;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\Customer;

class SaleController extends Controller
{


    public function create()
        {
            // ✅ 1. Voitures disponibles à la vente
            $vehiclesForSale = Vehicle::where('status', 'approved')->get();

            // ✅ 2. Liste des clients
            $customers = Customer::all();

            // ✅ 3. Envoyer les deux à la vue
            return view('sales.create', compact('vehiclesForSale', 'customers'));
        }



    public function store(Request $request)
        {
            $request->validate([
                'vehicle_id'   => 'required|exists:vehicles,id',
                'customer_id'  => 'required|exists:customers,id',
                'sold_price'   => 'required|numeric|min:0',
            ]);

            $vehicle = Vehicle::findOrFail($request->vehicle_id);

            if ($vehicle->status !== 'approved') {
                return back()->with('error', 'Seules les voitures approuvées peuvent être vendues.');
            }

            Sale::create([
                'vehicle_id'  => $vehicle->id,
                'customer_id' => $request->customer_id,
                'sold_by'     => auth()->id(),
                'sold_price'  => $request->sold_price,
                'sold_date'   => now(),
            ]);

            $vehicle->update([
                'status' => 'sold'
            ]);

            return redirect()->route('vehicles.index')
                ->with('success', 'Voiture vendue avec succès.');
        }

}
