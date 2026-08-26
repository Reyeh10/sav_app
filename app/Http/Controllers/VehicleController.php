<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
//use App\Imports\VehiclesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SoldVehiclesExport;
use App\Exports\VehiclesExport;
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
    // ✅ TOUS LES UTILISATEURS → TOUS LES VEHICULES
    $query = Vehicle::query();

    /*
    ===============================
    🔍 FILTRES DYNAMIQUES
    ===============================
    */

    if ($request->filled('vin')) {
        $query->where('vin', 'like', '%' . trim($request->vin) . '%');
    }

    if ($request->filled('brand')) {
        $query->where('brand', 'like', '%' . trim($request->brand) . '%');
    }

    if ($request->filled('model')) {
        $query->where('model', 'like', '%' . trim($request->model) . '%');
    }

    if ($request->filled('model_year')) {
        $query->where('model_year', $request->model_year);
    }

    if ($request->filled('color_interior')) {
        $query->where('color_interior', 'like', '%' . $request->color_interior . '%');
    }

    if ($request->filled('color_exterior')) {
        $query->where('color_exterior', 'like', '%' . $request->color_exterior . '%');
    }

    if ($request->filled('engine')) {
        $query->where('engine', 'like', '%' . $request->engine . '%');
    }

    if ($request->filled('configuration')) {
        $query->where('configuration', 'like', '%' . $request->configuration . '%');
    }

    if ($request->filled('engine_number')) {
        $query->where('engine_number', 'like', '%' . $request->engine_number . '%');
    }

    if ($request->filled('arrival_date')) {
        $query->whereDate('arrival_date', $request->arrival_date);
    }

    if ($request->filled('mileage')) {
        $query->where('mileage', $request->mileage);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    /*
    ===============================
    PAGINATION
    ===============================
    */
    $vehicles = $query->latest()->paginate(10);
    $vehicles->appends(request()->query());

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

    $allowedStatus = [
        'Disponible',
        'En réparation',
        'En attente',
        'Vendu',
        'Pièces prélevées',
    ];

    $validated = $request->validate([
        'vin' => 'required|string|max:100|unique:vehicles,vin',
        'brand' => 'required|string|max:100',
        'model' => 'required|string|max:100',
        'model_year' => 'nullable|integer|min:1900|max:2100',

        // Champs existants / compatibilité
        'engine' => 'nullable|string|max:100',
        'configuration' => 'nullable|string|max:255',
        'engine_number' => 'nullable|string|max:100',

        // Nouveaux champs techniques
        'engine_capacity' => 'nullable|string|max:50',
        'fuel_type' => 'nullable|string|max:50',
        'doors' => 'nullable|integer|min:1|max:20',
        'cylinders' => 'nullable|integer|min:1|max:20',
        'tire_size' => 'nullable|string|max:50',
        'transmission' => 'nullable|string|max:100',
        'seats' => 'nullable|integer|min:1|max:100',

        'mileage' => 'nullable|integer|min:0',
        'color_exterior' => 'nullable|string|max:50',
        'color_interior' => 'nullable|string|max:50',
        'arrival_date' => 'required|date',
        'comment' => 'nullable|string|max:1000',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'status' => 'nullable|string',
    ]);

    /*
    |--------------------------------------------------------------------------
    | STATUT
    |--------------------------------------------------------------------------
    | Admin peut choisir un statut autorisé.
    | Les autres profils créateurs démarrent à "En attente".
    */
    if ($role === 'admin') {
        $validated['status'] = in_array(
            $request->input('status'),
            $allowedStatus,
            true
        )
            ? $request->input('status')
            : 'En attente';
    } else {
        $validated['status'] = 'En attente';
    }

    $validated['mileage'] = $validated['mileage'] ?? 0;
    $validated['model_year'] = $validated['model_year'] ?? null;

    /*
    |--------------------------------------------------------------------------
    | SÉCURITÉ PAR RÔLE
    |--------------------------------------------------------------------------
    */
    if (!in_array($role, ['admin', 'logistique'], true)) {
        unset(
            $validated['vin'],
            $validated['brand'],
            $validated['model'],
            $validated['model_year'],
            $validated['engine'],
            $validated['configuration'],
            $validated['engine_number'],
            $validated['engine_capacity'],
            $validated['fuel_type'],
            $validated['doors'],
            $validated['cylinders'],
            $validated['tire_size'],
            $validated['transmission'],
            $validated['seats'],
            $validated['color_exterior'],
            $validated['color_interior'],
            $validated['arrival_date'],
            $validated['mileage']
        );
    }

    if (!in_array($role, ['admin', 'mecanicien'], true)) {
        unset($validated['comment']);
    }

    /*
    |--------------------------------------------------------------------------
    | IMAGE
    |--------------------------------------------------------------------------
    */
    if (
        in_array($role, ['admin', 'mecanicien'], true)
        && $request->hasFile('image')
    ) {
        $image = $request->file('image');

        $imageName =
            uniqid() . '_' . $image->getClientOriginalName();

        $destination =
            base_path('../storage/vehicles');

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $image->move(
            $destination,
            $imageName
        );

        $validated['image'] =
            'vehicles/' . $imageName;
    } else {
        unset($validated['image']);
    }

    Vehicle::create($validated);

    return redirect()
        ->route('vehicles.index')
        ->with(
            'success',
            'Véhicule ajouté ✅'
        );
}

/* ===============================
   EDIT
=============================== */
public function edit(Vehicle $vehicle)
{
    $role = auth()->user()->role;

    /*
    |--------------------------------------------------------------------------
    | VENDEUR
    |--------------------------------------------------------------------------
    |
    | Le vendeur peut modifier uniquement un véhicule disponible.
    | Les véhicules vendus, payés ou dans un autre statut sont verrouillés.
    |
    */
    if (
        $role === 'vendeur'
        && $vehicle->status !== 'Disponible'
    ) {
        return redirect()
            ->route('vehicles.index')
            ->with(
                'error',
                'Le vendeur peut modifier uniquement les véhicules disponibles.'
            );
    }

    $vehicle->load('sale.customer');

    $customers = \App\Models\Customer::all();

    return view(
        'vehicles.edit',
        compact('vehicle', 'customers')
    );
}
/* ===============================
   UPDATE (SÉCURISÉ PAR RÔLE)
=============================== */
public function update(Request $request, Vehicle $vehicle)
{
    $role = auth()->user()->role;

    $allowedStatus = [
        'Disponible',
        'En réparation',
        'En attente',
        'Vendu',
        'Pièces prélevées',
    ];

    /*
    |--------------------------------------------------------------------------
    | VENDEUR
    |--------------------------------------------------------------------------
    |
    | Le vendeur peut modifier les informations générales et techniques
    | uniquement lorsque le véhicule est disponible.
    |
    | Le vendeur ne peut pas modifier le statut.
    |
    */
    if ($role === 'vendeur') {

        if ($vehicle->status !== 'Disponible') {
            return redirect()
                ->route('vehicles.index')
                ->with(
                    'error',
                    'Le vendeur peut modifier uniquement les véhicules disponibles.'
                );
        }

        $data = $request->validate([
            'vin' => 'required|string|max:100|unique:vehicles,vin,' . $vehicle->id,
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'model_year' => 'nullable|integer|min:1900|max:2100',

            'engine' => 'nullable|string|max:100',
            'configuration' => 'nullable|string|max:255',
            'engine_number' => 'nullable|string|max:100',

            'engine_capacity' => 'nullable|string|max:50',
            'fuel_type' => 'nullable|string|max:50',
            'doors' => 'nullable|integer|min:1|max:20',
            'cylinders' => 'nullable|integer|min:1|max:20',
            'tire_size' => 'nullable|string|max:50',
            'transmission' => 'nullable|string|max:100',
            'seats' => 'nullable|integer|min:1|max:100',

            'color_exterior' => 'nullable|string|max:50',
            'color_interior' => 'nullable|string|max:50',
            'arrival_date' => 'required|date',
            'mileage' => 'nullable|integer|min:0',
            'comment' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /*
        |--------------------------------------------------------------------------
        | LE VENDEUR NE CHANGE PAS LE STATUT
        |--------------------------------------------------------------------------
        */
        $data['status'] = $vehicle->status;

        /*
        |--------------------------------------------------------------------------
        | IMAGE
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('image')) {

            if ($vehicle->image) {

                $oldImagePath = base_path(
                    '../storage/' . $vehicle->image
                );

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');

            $imageName =
                uniqid() . '_' .
                $image->getClientOriginalName();

            $destination =
                base_path('../storage/vehicles');

            if (!file_exists($destination)) {
                mkdir(
                    $destination,
                    0755,
                    true
                );
            }

            $image->move(
                $destination,
                $imageName
            );

            $data['image'] =
                'vehicles/' . $imageName;

        } else {
            unset($data['image']);
        }

        $vehicle->update($data);
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    elseif ($role === 'admin') {

        $data = $request->validate([
            'vin' => 'required|string|max:100|unique:vehicles,vin,' . $vehicle->id,
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'model_year' => 'nullable|integer|min:1900|max:2100',

            // Compatibilité avec l'ancien champ
            'engine' => 'nullable|string|max:100',

            'configuration' => 'nullable|string|max:255',
            'engine_number' => 'nullable|string|max:100',

            // Nouveaux champs techniques
            'engine_capacity' => 'nullable|string|max:50',
            'fuel_type' => 'nullable|string|max:50',
            'doors' => 'nullable|integer|min:1|max:20',
            'cylinders' => 'nullable|integer|min:1|max:20',
            'tire_size' => 'nullable|string|max:50',
            'transmission' => 'nullable|string|max:100',
            'seats' => 'nullable|integer|min:1|max:100',

            'color_exterior' => 'nullable|string|max:50',
            'color_interior' => 'nullable|string|max:50',
            'arrival_date' => 'required|date',
            'mileage' => 'nullable|integer|min:0',
            'comment' => 'nullable|string|max:1000',
            'status' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        $oldStatus = $vehicle->status;

        $newStatus = $data['status'] ?? $oldStatus;

        if (!in_array($newStatus, $allowedStatus, true)) {
            $newStatus = $oldStatus;
        }

        $data['status'] = $newStatus;

        /*
        |--------------------------------------------------------------------------
        | RETOUR VENDU → DISPONIBLE
        |--------------------------------------------------------------------------
        |
        | Lorsqu'une voiture vendue retourne dans le stock :
        |
        | - le prix de l'ancienne vente est remis à 0
        | - la date de vente est supprimée
        | - le véhicule redevient disponible
        |
        | Ainsi, lors d'une nouvelle vente, une nouvelle date
        | et un nouveau prix pourront être enregistrés.
        |
        */
        if (
            $oldStatus === 'Vendu'
            && $newStatus === 'Disponible'
        ) {

            /*
            |--------------------------------------------------------------------------
            | RÉINITIALISER L'ANCIENNE VENTE
            |--------------------------------------------------------------------------
            |
            | sold_date doit être nullable dans la table sales.
            | Une migration dédiée est fournie avec ce contrôleur.
            |
            */
            if ($vehicle->sale) {
                $vehicle->sale()->update([
                    'sold_price' => 0,
                    'sold_date' => null,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | RÉINITIALISER AUSSI LA DATE DE VENTE DU VÉHICULE
            |--------------------------------------------------------------------------
            |
            | La colonne vehicles.sold_at est utilisée dans la liste des véhicules
            | vendus. Elle doit donc être vidée lorsque le véhicule retourne en stock.
            |
            */
            $data['sold_at'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | IMAGE
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('image')) {

            if ($vehicle->image) {
                $oldImagePath =
                    base_path(
                        '../storage/' . $vehicle->image
                    );

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');

            $imageName =
                uniqid() . '_' .
                $image->getClientOriginalName();

            $destination =
                base_path('../storage/vehicles');

            if (!file_exists($destination)) {
                mkdir(
                    $destination,
                    0755,
                    true
                );
            }

            $image->move(
                $destination,
                $imageName
            );

            $data['image'] =
                'vehicles/' . $imageName;
        } else {
            unset($data['image']);
        }

        $customerId =
            $data['customer_id'] ?? null;

        unset($data['customer_id']);

        $vehicle->update($data);

        if (
            $customerId
            && $vehicle->sale
        ) {
            $vehicle->sale->update([
                'customer_id' => $customerId,
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | LOGISTIQUE
    |--------------------------------------------------------------------------
    */
    elseif ($role === 'logistique') {

        if ($vehicle->status === 'Vendu') {
            return redirect()
                ->route('vehicles.index')
                ->with(
                    'error',
                    'Ce véhicule est déjà vendu. Modification impossible.'
                );
        }

        $data = $request->validate([
            'vin' => 'required|string|max:100|unique:vehicles,vin,' . $vehicle->id,
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'model_year' => 'nullable|integer|min:1900|max:2100',

            // Compatibilité ancien champ
            'engine' => 'nullable|string|max:100',

            'configuration' => 'nullable|string|max:255',
            'engine_number' => 'nullable|string|max:100',

            // Nouveaux champs techniques
            'engine_capacity' => 'nullable|string|max:50',
            'fuel_type' => 'nullable|string|max:50',
            'doors' => 'nullable|integer|min:1|max:20',
            'cylinders' => 'nullable|integer|min:1|max:20',
            'tire_size' => 'nullable|string|max:50',
            'transmission' => 'nullable|string|max:100',
            'seats' => 'nullable|integer|min:1|max:100',

            'color_exterior' => 'nullable|string|max:50',
            'color_interior' => 'nullable|string|max:50',
            'arrival_date' => 'required|date',
            'mileage' => 'nullable|integer|min:0',
        ]);

        // Le statut reste inchangé.
        $data['status'] =
            $vehicle->status;

        $vehicle->update($data);
    }

    /*
    |--------------------------------------------------------------------------
    | MÉCANICIEN
    |--------------------------------------------------------------------------
    */
    elseif ($role === 'mecanicien') {

        if ($vehicle->status === 'Vendu') {
            return redirect()
                ->route('vehicles.index')
                ->with(
                    'error',
                    'Ce véhicule est déjà vendu. Modification impossible.'
                );
        }

        $data = $request->validate([
            'status' =>
                'required|in:Disponible,En réparation,En attente,Vendu,Pièces prélevées',

            'comment' =>
                'nullable|string|max:1000',

            'image' =>
                'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $updateData = [
            'status' => $data['status'],
            'comment' =>
                $data['comment']
                ?? $vehicle->comment,
        ];

        if ($request->hasFile('image')) {

            if ($vehicle->image) {
                $oldImagePath =
                    base_path(
                        '../storage/' . $vehicle->image
                    );

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');

            $imageName =
                uniqid() . '_' .
                $image->getClientOriginalName();

            $destination =
                base_path('../storage/vehicles');

            if (!file_exists($destination)) {
                mkdir(
                    $destination,
                    0755,
                    true
                );
            }

            $image->move(
                $destination,
                $imageName
            );

            $updateData['image'] =
                'vehicles/' . $imageName;
        }

        $vehicle->update($updateData);
    }

    /*
    |--------------------------------------------------------------------------
    | AUTRE RÔLE
    |--------------------------------------------------------------------------
    */
    else {
        return redirect()
            ->route('vehicles.index')
            ->with(
                'error',
                'Vous n’avez pas le droit de modifier.'
            );
    }

    return redirect()
        ->route('vehicles.index')
        ->with(
            'success',
            'Véhicule mis à jour ✅'
        );
}

/* ===============================
   SOLD VEHICLES + SEARCH + PAGINATION
=============================== */
/* ===============================
   SOLD VEHICLES + SEARCH + PAGINATION
=============================== */
public function sold(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES VÉHICULES VENDUS
    |--------------------------------------------------------------------------
    |
    | Un véhicule doit rester dans cette liste même lorsque sa facture
    | est totalement payée.
    |
    | Statuts considérés comme véhicules vendus :
    |
    | - Vendu
    | - Payé
    |
    | La relation "sale" utilise latestOfMany() afin de récupérer
    | la vente la plus récente du véhicule.
    |
    */

    $query = Vehicle::query()
        ->whereIn(
            'status',
            [
                'Vendu',
                'Payé',
            ]
        )
        ->with([
            'sale' => function ($query) {

                $query->with([
                    'customer',
                    'seller',
                ]);

            },
        ]);


    /*
    |--------------------------------------------------------------------------
    | RECHERCHE
    |--------------------------------------------------------------------------
    |
    | Recherche par :
    |
    | - VIN
    | - Marque
    | - Modèle
    | - Année
    |
    */

    if ($request->filled('search')) {

        $search = trim(
            (string) $request->input('search')
        );

        $query->where(
            function ($q) use ($search) {

                $q->where(
                    'vin',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'brand',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'model',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'model_year',
                    'like',
                    '%' . $search . '%'
                );

            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TRI
    |--------------------------------------------------------------------------
    |
    | Les véhicules les plus récemment vendus apparaissent en premier.
    |
    | sold_at est normalement enregistré lors de la vente.
    | Si deux véhicules ont la même date, on utilise l'ID.
    |
    */

    $vehicles = $query
        ->orderByDesc('sold_at')
        ->orderByDesc('id')
        ->paginate(10)
        ->withQueryString();


    /*
    |--------------------------------------------------------------------------
    | AFFICHAGE
    |--------------------------------------------------------------------------
    */

    return view(
        'vehicles.sold',
        compact('vehicles')
    );
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
/*public function grid()
{
   $vehicles = Vehicle::with('sale')->latest()->get();
    return view('vehicles.grid', compact('vehicles'));
}*/

public function grid(Request $request)
{
    $query = Vehicle::with('sale');

    /*
    =================================
    SEARCH
    =================================
    */
    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('brand', 'like', "%{$search}%")
              ->orWhere('model', 'like', "%{$search}%")
              ->orWhere('vin', 'like', "%{$search}%");
        });
    }

    /*
    =================================
    FILTER STATUS
    =================================
    */
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    /*
    =================================
    ORDER
    =================================
    */
    $vehicles = $query->latest()->get();

    /*
    =================================
    COUNTERS (POUR LES BADGES)
    =================================
    */
    $counts = [
        'total' => Vehicle::count(),
        'Disponible' => Vehicle::where('status', 'Disponible')->count(),
        'En attente' => Vehicle::where('status', 'En attente')->count(),
        'En réparation' => Vehicle::where('status', 'En réparation')->count(),
        'Vendu' => Vehicle::whereIn(
            'status',
            [
                'Vendu',
                'Payé',
            ]
        )->count(),
            ];

    return view('vehicles.grid', compact('vehicles', 'counts'));
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

/*public function updatePrice(Request $request, Vehicle $vehicle)
{
    $request->validate([
        'sold_price' => 'required'
    ]);

   // $price = floatval(str_replace(',', '', $request->sold_price));
    $price = str_replace(' ', '', $request->sold_price);
    $price = str_replace(',', '.', $price);

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
}*/
public function updatePrice(Request $request, Vehicle $vehicle)
{
    $request->validate([
        'sold_price' => 'required',
        'customer_id' => 'required|exists:customers,id'
    ]);

    // 🔥 Nettoyage prix
    $price = str_replace(' ', '', $request->sold_price);
    $price = str_replace(',', '.', $price);

    if ($price <= 0) {
        return back()->with('error', 'Le prix doit être supérieur à 0');
    }

    // 🔥 UPDATE SALE (prix + client)
    if ($vehicle->sale) {

        $vehicle->sale()->update([
            'sold_price' => $price,
            'customer_id' => $request->customer_id
        ]);

    } else {

        // 🔥 sécurité si jamais pas de sale
        \App\Models\Sale::create([
            'vehicle_id' => $vehicle->id,
            'customer_id' => $request->customer_id,
            'sold_by' => auth()->id(),
            'sold_price' => $price,
            'payment_type' => 'Cash',
            'sold_date' => now(),
        ]);
    }

    return redirect()
        ->route('vehicles.sold')
        ->with('success', 'Prix et client modifiés avec succès.');
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
            // Champs vente présents dans le nouveau fichier
            // ===============================
            $soldPrice     = $row[13] ?? null;
            $image         = trim((string)($row[14] ?? ''));
            $soldAtRaw     = $row[15] ?? null;

            // ===============================
            // Nouveaux champs techniques
            // ===============================
            $engineCapacity = trim((string)($row[16] ?? ''));
            $fuelType       = trim((string)($row[17] ?? ''));
            $doors          = is_numeric($row[18] ?? null) ? (int)$row[18] : null;
            $cylinders      = is_numeric($row[19] ?? null) ? (int)$row[19] : null;
            $tireSize       = trim((string)($row[20] ?? ''));
            $transmission   = trim((string)($row[21] ?? ''));
            $seats          = is_numeric($row[22] ?? null) ? (int)$row[22] : null;

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
            // Gestion de la date de vente
            // ===============================
            $soldAt = null;

            if (!empty($soldAtRaw)) {
                try {
                    if (is_numeric($soldAtRaw)) {
                        $soldAt = Carbon::instance(
                            Date::excelToDateTimeObject($soldAtRaw)
                        );
                    } else {
                        $soldAt = Carbon::parse($soldAtRaw);
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    return back()->with(
                        'error',
                        "Erreur ligne " . ($index + 1) . " : Format de date de vente invalide."
                    );
                }
            }

            // ===============================
            // Nettoyage du prix de vente
            // ===============================
            if ($soldPrice !== null && $soldPrice !== '') {
                $soldPrice = str_replace(' ', '', (string)$soldPrice);
                $soldPrice = str_replace(',', '.', $soldPrice);

                if (!is_numeric($soldPrice)) {
                    DB::rollBack();
                    return back()->with(
                        'error',
                        "Erreur ligne " . ($index + 1) . " : Prix de vente invalide."
                    );
                }

                $soldPrice = (float)$soldPrice;
            } else {
                $soldPrice = null;
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

                // Champs vente
                'sold_price' => $soldPrice,
                'image' => $image !== '' ? $image : null,
                'sold_at' => $soldAt,

                // Nouveaux champs techniques
                'engine_capacity' => $engineCapacity !== '' ? $engineCapacity : null,
                'fuel_type' => $fuelType !== '' ? $fuelType : null,
                'doors' => $doors,
                'cylinders' => $cylinders,
                'tire_size' => $tireSize !== '' ? $tireSize : null,
                'transmission' => $transmission !== '' ? $transmission : null,
                'seats' => $seats,
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
   Export
=============================== */

    public function exportSold()
    {
        // 🔒 sécurité ROLE
       if (!in_array(auth()->user()->role, ['admin', 'vendeur'])) {
            abort(403, 'Accès refusé');
        }

        return Excel::download(new SoldVehiclesExport, 'vehicules_vendus.xlsx');

    }


public function exportVehicles()
{

    return Excel::download(new VehiclesExport, 'vehicles_'.date('Y-m-d').'.xlsx');
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
