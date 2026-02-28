<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
//use App\Imports\VehiclesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{

/* ===============================
   LISTE VEHICLES
=============================== */
/* ===============================
   LISTE VEHICLES + SEARCH
=============================== */
public function index(Request $request)
{
    $role = auth()->user()->role;

    // On garde ta logique vendeur
    if ($role === 'vendeur') {
        $query = Vehicle::where('status', 'Disponible');
    } else {
        $query = Vehicle::query();
    }

    /* ===============================
       SEARCH (ajout sans supprimer logique)
    =============================== */
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('vin', 'like', "%{$search}%")
              ->orWhere('brand', 'like', "%{$search}%")
              ->orWhere('model', 'like', "%{$search}%")
              ->orWhere('color_exterior', 'like', "%{$search}%")
              ->orWhere('color_interior', 'like', "%{$search}%")
              ->orWhere('status', 'like', "%{$search}%");
        });
    }

    // Pagination propre
    $vehicles = $query->latest()->paginate(10);

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
    $role = auth()->user()->role;
    $allowedStatus = ['Disponible','En réparation','En attente','Vendu'];
    if ($role === 'admin') {
    $data['status'] = in_array($request->status, $allowedStatus)
        ? $request->status
        : 'En attente';
} else {
    // Logistique ne choisit pas
    $data['status'] = 'En attente';
}

    $request->validate([
        'vin'   => 'required|unique:vehicles,vin',
        'brand' => 'required|string|max:100',
        'model' => 'required|string|max:100',
        'model_year' => 'nullable|integer|min:1900|max:' . date('Y'),
        'engine' => 'nullable|in:Essence,Diesel,HEV,PHEV,Electrique',
        'configuration' => 'nullable|in:Basic,Medium Option,Full Option',
        'engine_number' => 'nullable|string|max:100',
        'mileage' => 'nullable|integer|min:0',
        'plate_number' => 'nullable|string|max:100',
        'color_exterior' => 'nullable|string|max:50',
        'color_interior' => 'nullable|string|max:50',
        'arrival_date' => 'nullable|date',
        'comment' => 'nullable|string|max:1000',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'status' => 'nullable|string'
    ]);

    $data = $request->all();

    $data['mileage'] = $request->mileage ?? 0;
    $data['model_year'] = $request->model_year ?? null;

    $data['status'] = in_array($request->status, $allowedStatus)
        ? $request->status
        : 'En attente';

    if ($role === 'admin' && $request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('vehicles', 'public');
    }

    Vehicle::create($data);

    return redirect()->route('vehicles.index')
        ->with('success','Véhicule ajouté ✅');
}

/* ===============================
   EDIT
=============================== */
public function edit(Vehicle $vehicle)
{
    $role = auth()->user()->role;

    // 🚫 Vendeur ne peut pas modifier
    if ($role === 'vendeur') {
        return redirect()->route('vehicles.index')
            ->with('error', 'Vous n’avez pas le droit de modifier.');
    }

    return view('vehicles.edit', compact('vehicle'));
}
/* ===============================
   UPDATE (SÉCURISÉ PAR RÔLE)
=============================== */
public function update(Request $request, Vehicle $vehicle)
{
    $allowedStatus = ['Disponible','En réparation','En attente','Vendu'];
    $role = auth()->user()->role;

    /* ================= ADMIN ================= */
    if ($role === 'admin') {

        $data = $request->all();

        if (isset($data['status']) && !in_array($data['status'], $allowedStatus)) {
            $data['status'] = $vehicle->status;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('vehicles', 'public');
        }

        $vehicle->update($data);
    }

    /* ================= LOGISTIQUE ================= */
    elseif ($role === 'logistique') {

        $data = $request->validate([
            'vin' => 'required|unique:vehicles,vin,' . $vehicle->id,
            'plate_number' => 'nullable|unique:vehicles,plate_number,' . $vehicle->id,
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'model_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'engine' => 'nullable|in:Essence,Diesel,HEV,PHEV,Electrique',
            'configuration' => 'nullable|in:Basic,Medium Option,Full Option',
            'engine_number' => 'nullable|string|max:100',
            'color_exterior' => 'nullable|string|max:50',
            'color_interior' => 'nullable|string|max:50',
            'arrival_date' => 'nullable|date',
            'mileage' => 'nullable|integer|min:0',
            'comment' => 'nullable|string|max:1000',
        ]);

        // 🔒 Status inchangé
        $data['status'] = $vehicle->status;

        $vehicle->update($data);
    }

    /* ================= MECANICIEN ================= */
elseif ($role === 'mecanicien') {

    $data = $request->validate([
        'status' => 'required|in:Disponible,En réparation,En attente,Vendu',
        'comment' => 'nullable|string|max:1000',
        'image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $updateData = [
        'status' => $data['status'],
        'comment' => $data['comment'] ?? $vehicle->comment,
    ];

    if ($request->hasFile('image')) {
        $updateData['image'] = $request->file('image')->store('vehicles', 'public');
    }

    // 🔒 Mise à jour UNIQUEMENT de ces champs
    $vehicle->update($updateData);
}

    /* ================= VENDEUR ================= */
    else {
        return redirect()->route('vehicles.index')
            ->with('error','Vous n’avez pas le droit de modifier.');
    }

    return redirect()->route('vehicles.index')
        ->with('success','Véhicule mis à jour ✅');
}

/* ===============================
   SOLD VEHICLES + SEARCH + PAGINATION
=============================== */
public function sold(Request $request)
{
    $query = Vehicle::where('status', 'Vendu');

    // 🔎 Recherche
    if ($request->filled('search')) {
        $search = trim($request->search);

        $query->where(function ($q) use ($search) {
            $q->where('vin', 'like', "%{$search}%")
              ->orWhere('brand', 'like', "%{$search}%")
              ->orWhere('model', 'like', "%{$search}%");
        });
    }

    $vehicles = $query->latest()->paginate(10);

    return view('vehicles.sold', compact('vehicles'));
}

/* ===============================
   VOITURES APPROUVÉES (DISPONIBLES)
=============================== */
/* ===============================
   VOITURES APPROUVÉES (DISPONIBLES) + SEARCH
=============================== */
public function approved(Request $request)
{
    $query = Vehicle::where('status', 'Disponible');

    // ✅ Recherche
    if ($request->filled('search')) {
        $search = trim($request->search);

        $query->where(function ($q) use ($search) {
            $q->where('vin', 'like', "%{$search}%")
              ->orWhere('brand', 'like', "%{$search}%")
              ->orWhere('model', 'like', "%{$search}%")
              ->orWhere('color_exterior', 'like', "%{$search}%")
              ->orWhere('color_interior', 'like', "%{$search}%")
              ->orWhere('engine', 'like', "%{$search}%")
              ->orWhere('configuration', 'like', "%{$search}%")
              ->orWhere('engine_number', 'like', "%{$search}%");
        });
    }

    // ✅ Pagination (important pour garder la query string)
    $vehicles = $query->latest()->paginate(10);

    return view('vehicles.approved', compact('vehicles'));
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
   SHOW VEHICLE DETAILS
=============================== */
public function show(Vehicle $vehicle)
{
    return view('vehicles.show', compact('vehicle'));
}


/* ===============================
   Edit &bUpdate price
=============================== */
public function editPrice(Vehicle $vehicle)
{
    return view('vehicles.edit-price', compact('vehicle'));
}

public function updatePrice(Request $request, Vehicle $vehicle)
{
    $request->validate([
        'sold_price' => 'required'
    ]);

    $price = floatval(str_replace(',', '', $request->sold_price));

    if ($price <= 0) {
        return back()->with('error', 'Le prix doit être supérieur à 0');
    }

    // 🔥 Mettre à jour dans la table sales
    $vehicle->sale()->update([
        'sold_price' => $price
    ]);

    return redirect()
        ->route('vehicles.sold')
        ->with('success', 'Prix modifié avec succès.');
}
/* ===============================
   Import excel
=============================== */
public function importExcel(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    $file = $request->file('file');

    $data = Excel::toArray([], $file);

    foreach ($data[0] as $index => $row) {

        if ($index == 0) continue; // ignorer header

        Vehicle::create([
            'vin' => $row[0] ?? null,
            'brand' => $row[1] ?? null,
            'model' => $row[2] ?? null,
            'model_year' => $row[3] ?? null,
            'engine' => $row[4] ?? null,
            'configuration' => $row[5] ?? null,
            'engine_number' => $row[6] ?? null,
            'color_exterior' => $row[7] ?? null,
            'color_interior' => $row[8] ?? null,
            'arrival_date' => $row[9] ?? null,
            'mileage' => $row[10] ?? 0,
            'comment' => $row[11] ?? null,
            'status' => $row[12] ?? 'En attente',
        ]);
    }

    return back()->with('success', 'Import réussi !');
}
/* ===============================
   DELETE (ADMIN SEULEMENT)
=============================== */
public function destroy(Vehicle $vehicle)
{
    if (auth()->user()->role !== 'admin') {
        return redirect()->route('vehicles.index')
            ->with('error','Seul l\'admin peut supprimer.');
    }

    if ($vehicle->image && Storage::disk('public')->exists($vehicle->image)) {
        Storage::disk('public')->delete($vehicle->image);
    }

    $vehicle->delete();

    return redirect()->route('vehicles.index')
        ->with('success', 'Véhicule supprimé ✅');
}

}
