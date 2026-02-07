<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
//use App\Models\User;
use Illuminate\Http\Request;

use App\Imports\VehiclesImport;
use Maatwebsite\Excel\Facades\Excel;

class VehicleController extends Controller
{
    /* ===============================
       ✅ LISTE VEHICLES (Tous)
       vendeur voit seulement "Disponible"
    =============================== */
    public function index()
        {
            if(auth()->user()->role === 'vendeur'){
                $vehicles = Vehicle::where('status','approved')->get();
            }else{
                $vehicles = Vehicle::latest()->get();
            }

            return view('vehicles.index',compact('vehicles'));
        }



    /* ===============================
       ✅ CREATE (Admin + Logistique)
    =============================== */
    public function create()
    {
        return view('vehicles.create');
    }


    /* ===============================
       ✅ STORE (Logistique)
       Status automatique
    =============================== */
   public function store(Request $request)
        {
            $data = $request->validate([
                'vin' => 'required|unique:vehicles,vin',
                'plate_number' => 'nullable|unique:vehicles,plate_number',
                'brand' => 'required',
                'model' => 'required',
                'year' => 'required|integer',
                'color_exterior'=> 'nullable|string|max:50',
                'color_interior'=> 'nullable|string|max:50',
                'arrival_date'  => 'nullable|date',
                'mileage'       => 'required|integer',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ]);

            $data['status'] = "draft";

            if($request->hasFile('image')){
                $data['image'] = $request->file('image')->store('vehicles','public');
            }

            Vehicle::create($data);

            return redirect()->route('vehicles.index')
                ->with('success','Véhicule ajouté ✅');
        }



    /* ===============================
       ✅ EDIT (Admin + Logistique)
    =============================== */
    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }


    /* ===============================
       ✅ UPDATE (Logistique)
       Ne touche PAS status
    =============================== */
        public function update(Request $request, Vehicle $vehicle)
{

    /* =========================
    LOGISTIQUE → INFOS VEHICULE
    ========================= */
    if(auth()->user()->role === 'logistique'){

        $data = $request->validate([
            'vin'            => 'required|unique:vehicles,vin,' . $vehicle->id,
            'plate_number'   => 'nullable|unique:vehicles,plate_number,' . $vehicle->id,
            'brand'          => 'required',
            'model'          => 'required',
            'year'           => 'required|integer',
            'color_exterior' => 'nullable|string|max:50',
            'color_interior' => 'nullable|string|max:50',
            'arrival_date'   => 'nullable|date',
            'mileage'        => 'required|integer',
        ]);

        $vehicle->update($data);
    }


    /* =========================
    MECANICIEN → IMAGE + STATUS
    ========================= */
    if(auth()->user()->role === 'mecanicien'){

        $data = $request->validate([
            'status' => 'required|string',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('vehicles','public');
        }

        $vehicle->update($data);
    }


    /* =========================
    ADMIN → TOUT
    ========================= */
    if(auth()->user()->role === 'admin'){

        $data = $request->validate([
            'vin'            => 'required|unique:vehicles,vin,' . $vehicle->id,
            'plate_number'   => 'nullable|unique:vehicles,plate_number,' . $vehicle->id,
            'brand'          => 'required',
            'model'          => 'required',
            'year'           => 'required|integer',
            'color_exterior' => 'nullable|string|max:50',
            'color_interior' => 'nullable|string|max:50',
            'arrival_date'   => 'nullable|date',
            'mileage'        => 'required|integer',
            'status'         => 'required|string',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('vehicles','public');
        }

        $vehicle->update($data);
    }

    return redirect()->route('vehicles.index')
        ->with('success','Véhicule mis à jour ✅');
}



    /* ===============================
       ✅ TRANSMETTRE INSPECTION
       Logistique uniquement
    =============================== */
    public function sendToInspection(Vehicle $vehicle)
    {
        if ($vehicle->status !== "En attente inspection") {
            return back()->with('error',
                "Seuls les véhicules en attente peuvent être transmis.");
        }

        $vehicle->update([
            'status' => "En cours d'inspection"
        ]);

        return back()->with('success', "Véhicule transmis ✅");
    }


    /* ===============================
       ✅ MECANICIEN : FORM INSPECTION
    =============================== */
    public function inspectionForm(Vehicle $vehicle)
    {
        return view('vehicles.inspection', compact('vehicle'));
    }


    /* ===============================
       ✅ MECANICIEN : UPDATE STATUS
       Status seulement
    =============================== */
    public function updateInspectionStatus(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $vehicle->update([
            'status' => $request->status
        ]);
        if (!in_array(auth()->user()->role, ['admin','mecanicien'])) {
            abort(403);
        }

        return redirect()->route('vehicles.index')
            ->with('success', "Statut mis à jour par mécanicien ✅");
    }


    /* ===============================
       ✅ APPROVED PAGE (vendeur)
    =============================== */
    public function approved()
    {
        $vehicles = Vehicle::where('status', 'approved')->get();

        return view('vehicles.approved', compact('vehicles'));
    }

    public function grid()
        {
            $vehicles = Vehicle::latest()->get();

            return view('vehicles.grid', compact('vehicles'));
        }



    /* ===============================
       ✅ DELETE (Admin only)
    =============================== */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', "Véhicule supprimé ✅");
    }
         /* ===============================
       voiture vendu
    =============================== */
        public function sold()
            {
                $vehicles = Vehicle::where('status', 'sold')->get();

                return view('vehicles.sold', compact('vehicles'));
            }

    /* ===============================
       ✅ IMPORT EXCEL (Logistique)
       Status automatique
    =============================== */
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new VehiclesImport, $request->file('file'));

        return redirect()->route('vehicles.index')
            ->with('success', "Import terminé ✅");
    }

    public function importForm()
        {
            return view('vehicles.import');
        }


}
