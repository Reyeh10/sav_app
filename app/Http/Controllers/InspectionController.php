<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function store(Request $request)
    {
        $inspection = Inspection::create([
            'vehicle_id' => $request->vehicle_id,
            'inspector_id' => auth()->id(),
            'mechanical_state' => $request->mechanical_state,
            'body_state' => $request->body_state,
            'status' => $request->status,
            'inspected_at' => now()
        ]);

        // Mise à jour automatique du statut voiture
        $inspection->vehicle->update([
            'status' => $inspection->status
        ]);

        return redirect()->route('vehicles.index')
            ->with('success', 'Inspection enregistrée ✅');
    }


}
