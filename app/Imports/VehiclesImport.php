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
        /*
        =====================================================
        SUPPORT MULTI-NOMS (FR + EN + TON EXCEL ACTUEL)
        =====================================================
        */

        $vin = $row['vin'] ?? null;

        $brand = $row['brand']
            ?? $row['marque']
            ?? null;

        $model = $row['model']
            ?? $row['modele']
            ?? $row['modèle']
            ?? null;

        $year = $row['model_year']
            ?? $row['année']
            ?? $row['annee']
            ?? null;

        if (empty($vin) || empty($brand) || empty($model) || empty($year)) {
            throw new Exception(
                "Erreur Import : VIN, Marque/Brand, Modèle/Model et Année/Model year sont obligatoires."
            );
        }

        /*
        =====================================
        DATE ARRIVEE
        =====================================
        */
        $arrivalDate = null;

        $arrivalRaw = $row['arrival_date']
            ?? $row['date_arrivee']
            ?? $row['date arrivée']
            ?? null;

        if (!empty($arrivalRaw)) {
            try {
                $arrivalDate = Carbon::parse($arrivalRaw)->format('Y-m-d');
            } catch (\Exception $e) {
                $arrivalDate = null;
            }
        }

        /*
        =====================================
        NOUVEAUX CHAMPS
        =====================================
        */
        $engine = $row['engine'] ?? null;
        $configuration = $row['configuration'] ?? null;
        $engineNumber = $row['engine_number']
            ?? $row['engine number']
            ?? null;

        /*
        =====================================
        ✅ CORRECTION STATUS (ANTI ERREUR SQL)
        =====================================
        */

        $allowedStatus = [
            'Disponible',
            'En réparation',
            'En attente',
            'Vendu'
        ];

        $rawStatus = $row['status']
            ?? $row['statut']
            ?? null;

        $rawStatus = trim($rawStatus);

        // Si statut vide ou incorrect → valeur par défaut
        if (!in_array($rawStatus, $allowedStatus)) {
            $rawStatus = 'En attente';
        }

        return new Vehicle([
            'vin' => $vin,
            'brand' => $brand,
            'model' => $model,
            'year' => $year,

            'color_exterior' => $row['color_exterior']
                ?? $row['extérieur']
                ?? $row['exterieur']
                ?? null,

            'color_interior' => $row['color_interior']
                ?? $row['intérieur']
                ?? $row['interieur']
                ?? null,

            'engine' => $engine,
            'configuration' => $configuration,
            'engine_number' => $engineNumber,

            'arrival_date' => $arrivalDate,

            'mileage' => $row['mileage']
                ?? $row['kilométrage']
                ?? $row['kilometrage']
                ?? 0,

            // ✅ STATUS sécurisé
            'status' => $rawStatus,
        ]);
    }
}
