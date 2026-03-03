<?php

namespace App\Imports;

use App\Models\Vehicle;
use Carbon\Carbon;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date; // ✅ Ajout pour gérer dates Excel numériques

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
        DATE ARRIVEE (OBLIGATOIRE + SECURISEE)
        =====================================
        */
        $arrivalDate = null;

        $arrivalRaw = $row['arrival_date']
            ?? $row['date_arrivee']
            ?? $row['date arrivée']
            ?? null;

        // ✅ AJOUT : Date obligatoire
        if (empty($arrivalRaw)) {
            throw new Exception(
                "Erreur Import : La date d'arrivée est obligatoire."
            );
        }

        try {

            // ✅ Gérer dates Excel numériques
            if (is_numeric($arrivalRaw)) {
                $arrivalDate = Carbon::instance(
                    Date::excelToDateTimeObject($arrivalRaw)
                )->format('Y-m-d');
            } else {
                $arrivalDate = Carbon::parse($arrivalRaw)->format('Y-m-d');
            }

        } catch (\Exception $e) {
            throw new Exception(
                "Erreur Import : Format de date d'arrivée invalide."
            );
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
        ];

        $rawStatus = $row['status']
            ?? $row['statut']
            ?? null;

        $rawStatus = trim($rawStatus);

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

            'status' => $rawStatus,
        ]);
    }
}
