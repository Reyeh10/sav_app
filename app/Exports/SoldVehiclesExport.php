<?php

namespace App\Exports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SoldVehiclesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Vehicle::where('status', 'Vendu')
            ->with('sale.customer')
            ->get()
            ->map(function ($vehicle) {
                return [
                    'VIN' => $vehicle->vin,
                    'Marque' => $vehicle->brand,
                    'Modèle' => $vehicle->model,
                    'Année' => $vehicle->model_year,
                    'Prix' => optional($vehicle->sale)->sold_price,
                    'Date vente' => optional($vehicle->sale)->sold_date,
                    'Client' => optional($vehicle->sale->customer)->name,
                    'Statut' => 'Vendu',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'VIN',
            'Marque',
            'Modèle',
            'Année',
            'Prix',
            'Date vente',
            'Client',
            'Statut'
        ];
    }
}
