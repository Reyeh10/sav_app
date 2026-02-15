<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
//use App\Imports\VehiclesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;   // ✅ AJOUTE ÇA
//use Maatwebsite\Excel\Facades\Excel;
//use Maatwebsite\Excel\Validators\ValidationException;

class VehicleController extends Controller
{

/* ===============================
   LISTE VEHICLES
=============================== */
public function index()
{
    $role = auth()->user()->role;

    if ($role === 'vendeur') {
        $vehicles = Vehicle::where('status', 'approved')->latest()->get();
    } else {
        $vehicles = Vehicle::latest()->get();
    }

    return view('vehicles.index', compact('vehicles'));
}


/* ===============================
   CREATE
=============================== */
public function create()
{
    return view('vehicles.create');
}


/* ===============================
   STORE
=============================== */
public function store(Request $request)
{
    $request->validate([
        'vin'   => 'required|unique:vehicles,vin',
        'brand' => 'required|string|max:100',
        'model' => 'required|string|max:100',
        'year'  => 'required|integer|min:1900|max:' . date('Y'),
        'mileage' => 'nullable|integer',
        'plate_number' => 'nullable|string|max:100',
        'color_exterior' => 'nullable|string|max:50',
        'color_interior' => 'nullable|string|max:50',
        'arrival_date' => 'nullable|date',
        'comment' => 'nullable|string|max:1000',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'vin.required'   => 'Le champ VIN est obligatoire.',
        'brand.required' => 'Le champ Marque est obligatoire.',
        'model.required' => 'Le champ Modèle est obligatoire.',
        'year.required'  => 'Le champ Année est obligatoire.',
    ]);

    Vehicle::create($request->all());

    return redirect()->route('vehicles.index')
        ->with('success','Véhicule ajouté ✅');
}



/* ===============================
   EDIT
=============================== */
public function edit(Vehicle $vehicle)
{
    return view('vehicles.edit', compact('vehicle'));
}

/* ===============================
   SHOW VEHICLE DETAILS
=============================== */
public function show(Vehicle $vehicle)
{
    return view('vehicles.show', compact('vehicle'));
}

/* ===============================
   GRID VIEW
=============================== */
public function grid()
{
    $vehicles = Vehicle::latest()->get();
    return view('vehicles.grid', compact('vehicles'));
}
/* ===============================
   VOITURES APPROUVEES
=============================== */
public function approved()
{
    $vehicles = Vehicle::where('status', 'approved')
        ->latest()
        ->get();

    return view('vehicles.approved', compact('vehicles'));
}

/* ===============================
   VOITURES VENDUES
=============================== */
public function sold()
{
    $vehicles = Vehicle::with('sale')
        ->where('status', 'sold')
        ->latest()
        ->get();

    return view('vehicles.sold', compact('vehicles'));
}
/* ===============================
   IMPORT EXCEL
=============================== */
public function importExcel(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    try {

        \Maatwebsite\Excel\Facades\Excel::import(
            new \App\Imports\VehiclesImport,
            $request->file('file')
        );

    } catch (\Exception $e) {

        return back()->withErrors([
            'file' => $e->getMessage()
        ]);
    }

    return redirect()->route('vehicles.index')
        ->with('success', 'Import réussi ✅');
}



/* ===============================
   UPDATE PRINCIPAL
=============================== */
public function update(Request $request, Vehicle $vehicle)
{
    $role = auth()->user()->role;

    /* ================= LOGISTIQUE ================= */
    if ($role === 'logistique') {

        $data = $request->validate([
            'vin' => 'required|unique:vehicles,vin,' . $vehicle->id,
            'plate_number' => 'nullable|unique:vehicles,plate_number,' . $vehicle->id,
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer',
            'color_exterior' => 'nullable|string|max:50',
            'color_interior' => 'nullable|string|max:50',
            'arrival_date' => 'nullable|date',
            'mileage' => 'required|integer',
            'comment' => 'nullable|string|max:1000',
        ]);

        $vehicle->update($data);
    }

    /* ================= MECANICIEN ================= */
    elseif ($role === 'mecanicien') {

        $data = $request->validate([
            'status' => 'required|string',
            'comment' => 'nullable|string|max:1000',   // ✅ AJOUT IMPORTANT
            'image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('vehicles', 'public');
        }

        $vehicle->update($data);
    }

    /* ================= ADMIN ================= */
    elseif ($role === 'admin') {

        $data = $request->validate([
            'vin' => 'required|unique:vehicles,vin,' . $vehicle->id,
            'plate_number' => 'nullable|unique:vehicles,plate_number,' . $vehicle->id,
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer',
            'color_exterior' => 'nullable|string|max:50',
            'color_interior' => 'nullable|string|max:50',
            'arrival_date' => 'nullable|date',
            'mileage' => 'required|integer',
            'status' => 'required|string',
            'comment' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('vehicles', 'public');
        }

        $vehicle->update($data);
    }

    return redirect()->route('vehicles.index')
        ->with('success','Véhicule mis à jour ✅');
}
/* ===============================
   DELETE
=============================== */
public function destroy(Vehicle $vehicle)
{
    if ($vehicle->image && Storage::disk('public')->exists($vehicle->image)) {
        Storage::disk('public')->delete($vehicle->image);
    }

    $vehicle->delete();

    return redirect()->route('vehicles.index')
        ->with('success', 'Véhicule supprimé ✅');
}

}
