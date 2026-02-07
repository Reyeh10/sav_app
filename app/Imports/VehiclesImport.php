<?php

namespace App\Imports;

use App\Models\Vehicle;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VehiclesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        /*
        =====================================
        SECURITE : VIN obligatoire
        =====================================
        */
        if(empty($row['vin'])){
            return null;
        }

        /*
        =====================================
        DATE ARRIVEE (Excel → Date Laravel)
        =====================================
        */
        $arrivalDate = null;

        if(!empty($row['date arriv'])){
            try{
                $arrivalDate = Carbon::parse($row['date arriv'])->format('Y-m-d');
            }catch(\Exception $e){
                $arrivalDate = null;
            }
        }

        /*
        =====================================
        RETURN VEHICLE
        =====================================
        */
        return new Vehicle([

            // ===== IDENTIFICATION =====
            'vin' => $row['vin'] ?? null,

            // ===== INFOS VEHICULE =====
            'brand' => $row['marque']
                    ?? $row['brand']
                    ?? null,

            'model' => $row['modèle']
                    ?? $row['modele']
                    ?? null,

            'year' => $row['année']
                    ?? $row['annee']
                    ?? null,

            // ===== COULEURS =====
            'color_exterior' => $row['extérieur']
                              ?? $row['exterieur']
                              ?? null,

            'color_interior' => $row['intérieur']
                              ?? $row['interieur']
                              ?? null,

            // ===== DATE =====
            'arrival_date' => $arrivalDate,

            // ===== KM =====
            'mileage' => $row['kilométrage']
                       ?? $row['kilometrage']
                       ?? 0,

            // ===== STATUS =====
            'status' => strtolower($row['statut'] ?? 'draft'),

        ]);
    }
}
