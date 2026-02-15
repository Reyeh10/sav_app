<?php

namespace App\Imports;

use App\Models\Vehicle;
use Carbon\Carbon;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VehiclesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $vin    = $row['vin'] ?? null;
        $brand  = $row['marque'] ?? $row['brand'] ?? null;
        $model  = $row['modèle'] ?? $row['modele'] ?? null;
        $year   = $row['année'] ?? $row['annee'] ?? null;

        /*
        =====================================
        BLOQUER SI CHAMP OBLIGATOIRE MANQUANT
        =====================================
        */
        if(empty($vin) || empty($brand) || empty($model) || empty($year)){
            throw new Exception(
                "Erreur Import : VIN, Marque, Modèle et Année sont obligatoires. Vérifiez votre fichier Excel."
            );
        }

        /*
        =====================================
        DATE ARRIVEE
        =====================================
        */
        $arrivalDate = null;

        if(!empty($row['date arrivée']) || !empty($row['date arrivee'])){
            try{
                $arrivalDate = Carbon::parse(
                    $row['date arrivée'] ?? $row['date arrivee']
                )->format('Y-m-d');
            }catch(\Exception $e){
                $arrivalDate = null;
            }
        }

        return new Vehicle([
            'vin' => $vin,
            'brand' => $brand,
            'model' => $model,
            'year' => $year,
            'color_exterior' => $row['extérieur'] ?? $row['exterieur'] ?? null,
            'color_interior' => $row['intérieur'] ?? $row['interieur'] ?? null,
            'arrival_date' => $arrivalDate,
            'mileage' => $row['kilométrage'] ?? $row['kilometrage'] ?? 0,
            'status' => strtolower($row['statut'] ?? 'draft'),
        ]);
    }
}
