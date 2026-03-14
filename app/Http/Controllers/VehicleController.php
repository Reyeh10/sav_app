<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
//use App\Imports\VehiclesImport;
use Maatwebsite\Excel\Facades\Excel;
//use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;


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
            'configuration' => 'nullable|string|max:255',
            'engine_number' => 'nullable|string|max:100',
            'mileage' => 'nullable|integer|min:0',
           // 'plate_number' => 'nullable|string|max:100',
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


   // $data['image'] = $request->file('image')->store('vehicles', 'public');
  /*if (in_array($role, ['admin','mecanicien']) && $request->hasFile('image')) {

    $image = $request->file('image');

    $imageName = time().'_'.$image->getClientOriginalName();

    // déplacer dans public/storage/vehicles
    $image->move(public_path('storage/vehicles'), $imageName);

    $data['image'] = 'vehicles/'.$imageName;
}*/
    if (in_array($role, ['admin','mecanicien']) && $request->hasFile('image')) {

    $image = $request->file('image');

    $imageName = uniqid().'_'.$image->getClientOriginalName();

    $destination = base_path('../storage/vehicles');

    if (!file_exists($destination)) {
        mkdir($destination, 0755, true);
    }

    $image->move($destination, $imageName);

    $data['image'] = 'vehicles/'.$imageName;
}



        /*
    ================= CONFIGURATION SECURITY =================
    logistique et vendeur ne peuvent pas modifier
    */

    if (!in_array($role, ['admin','mecanicien'])) {
        unset($data['configuration']);
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

    // Supprimer ancienne image
    if ($vehicle->image) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($vehicle->image);
    }

    //$data['image'] = $request->file('image')->store('vehicles', 'public');
        /*if (in_array($role, ['admin','mecanicien']) && $request->hasFile('image')) {

        $image = $request->file('image');

        $imageName = time().'_'.$image->getClientOriginalName();

        // déplacer dans public/storage/vehicles
        $image->move(public_path('storage/vehicles'), $imageName);

        $data['image'] = 'vehicles/'.$imageName;
    }*/
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = uniqid().'_'.$image->getClientOriginalName();

            $destination = base_path('../storage/vehicles');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $image->move($destination, $imageName);

            $data['image'] = 'vehicles/'.$imageName;
        }


    }

        $vehicle->update($data);
    }

    /* ================= LOGISTIQUE ================= */
    elseif ($role === 'logistique') {
        // 🚫 Si véhicule vendu → aucune modification possible
        if ($vehicle->status === 'Vendu') {
            return redirect()->route('vehicles.index')
                ->with('error','Ce véhicule est déjà vendu. Modification impossible.');
    }
        $data = $request->validate([
            'vin' => 'required|unique:vehicles,vin,' . $vehicle->id,
            'plate_number' => 'nullable|unique:vehicles,plate_number,' . $vehicle->id,
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'model_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'engine' => 'nullable|in:Essence,Diesel,HEV,PHEV,Electrique',
            'configuration' => 'nullable|string|max:255',
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

    // 🚫 Si véhicule vendu → aucune modification possible
        if ($vehicle->status === 'Vendu') {
            return redirect()->route('vehicles.index')
                ->with('error','Ce véhicule est déjà vendu. Modification impossible.');
    }
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
        $image = $request->file('image');

        $imageName = uniqid().'_'.$image->getClientOriginalName();

        $destination = base_path('../storage/vehicles');

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $image->move($destination, $imageName);

        $updateData['image'] = 'vehicles/'.$imageName;
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

    //$vehicles = $query->latest()->paginate(10);
    $vehicles = $query
    ->with('sale')   // ✅ AJOUT IMPORTANT
    ->latest()
    ->paginate(10);

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
   $vehicles = Vehicle::with('sale')->latest()->get();
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

    if (empty($data) || empty($data[0])) {
        return back()->with('error', 'Fichier vide ou invalide.');
    }

    DB::beginTransaction();

    try {

        foreach ($data[0] as $index => $row) {

            // Ignorer header
            if ($index == 0) continue;

            // Ignorer lignes complètement vides
            if (empty(array_filter($row))) {
                continue;
            }

            // ===============================
            // Récupération sécurisée des champs
            // ===============================
            $vin           = trim($row[0] ?? '');
            $brand         = trim($row[1] ?? '');
            $model         = trim($row[2] ?? '');
            $modelYear     = $row[3] ?? null;
            $engine        = trim($row[4] ?? '');
            $configuration = trim($row[5] ?? '');
            $engineNumber  = trim($row[6] ?? '');
            $colorExterior = trim($row[7] ?? '');
            $colorInterior = trim($row[8] ?? '');
            $arrivalRaw    = $row[9] ?? null;
            $mileage       = is_numeric($row[10] ?? null) ? $row[10] : 0;
            $comment       = $row[11] ?? null;
            $status        = $row[12] ?? 'En attente';

            // ===============================
            // CHAMPS OBLIGATOIRES
            // ===============================
            if (
                empty($vin) ||
                empty($brand) ||
                empty($model) ||
                empty($engine) ||
                empty($configuration) ||
                empty($colorExterior) ||
                empty($colorInterior) ||
                empty($arrivalRaw)   // ✅ DATE OBLIGATOIRE
            ) {
                DB::rollBack();
                return back()->with(
                    'error',
                    "Erreur ligne " . ($index + 1) . " : Champs obligatoires manquants."
                );
            }

            // ===============================
            // VIN UNIQUE
            // ===============================
            if (Vehicle::where('vin', $vin)->exists()) {
                DB::rollBack();
                return back()->with(
                    'error',
                    "Erreur ligne " . ($index + 1) . " : VIN déjà existant."
                );
            }

            // ===============================
// Gestion obligatoire et sécurisée de la date
// ===============================

if (empty($arrivalRaw)) {
    DB::rollBack();
    return back()->with(
        'error',
        "Erreur ligne " . ($index + 1) . " : La date d'arrivée est obligatoire."
    );
}

try {

    // Si Excel envoie une date numérique
                if (is_numeric($arrivalRaw)) {
                    $arrivalDate = Carbon::instance(
                       Date::excelToDateTimeObject($arrivalRaw)
                    );
                } else {
                    $arrivalDate = Carbon::parse($arrivalRaw);
                }

                    } catch (\Exception $e) {
                        DB::rollBack();
                        return back()->with(
                            'error',
                            "Erreur ligne " . ($index + 1) . " : Format de date invalide."
                        );
                    }
            // ===============================
            // Création véhicule
            // ===============================
            Vehicle::create([
                'vin' => $vin,
                'brand' => $brand,
                'model' => $model,
                'model_year' => $modelYear,
                'engine' => $engine,
                'configuration' => $configuration,
                'engine_number' => $engineNumber,
                'color_exterior' => $colorExterior,
                'color_interior' => $colorInterior,
                'arrival_date' => $arrivalDate,
                'mileage' => $mileage,
                'comment' => $comment,
                'status' => $status,
            ]);
        }

        DB::commit();

        return back()->with('success', 'Import réussi !');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with(
            'error',
            'Erreur lors de l’import : ' . $e->getMessage()
        );
    }
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

        // Supprimer l'image si elle existe
        if ($vehicle->image) {

            $path = base_path('../storage/'.$vehicle->image);

            if (file_exists($path)) {
                unlink($path);
            }
        }

        // supprimer le véhicule
        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', 'Véhicule supprimé ✅');
    }

}
