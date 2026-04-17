<?php

namespace App\Exports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehiclesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $query = Vehicle::query();

        // 🔍 FILTRES DYNAMIQUES
        if ($vin = request('vin')) {
            $query->where('vin', 'like', "%$vin%");
        }

        if ($brand = request('brand')) {
            $query->where('brand', 'like', "%$brand%");
        }

        if ($model = request('model')) {
            $query->where('model', 'like', "%$model%");
        }

        if ($colorInterior = request('color_interior')) {
            $query->where('color_interior', 'like', "%$colorInterior%");
        }

        if ($colorExterior = request('color_exterior')) {
            $query->where('color_exterior', 'like', "%$colorExterior%");
        }

        if ($year = request('model_year')) {
            $query->where('model_year', $year);
        }

        if ($engine = request('engine')) {
            $query->where('engine', 'like', "%$engine%");
        }

        if ($config = request('configuration')) {
            $query->where('configuration', 'like', "%$config%");
        }

        if ($engineNumber = request('engine_number')) {
            $query->where('engine_number', 'like', "%$engineNumber%");
        }

        if ($arrivalDate = request('arrival_date')) {
            $query->whereDate('arrival_date', $arrivalDate);
        }

        if ($mileage = request('mileage')) {
            $query->where('mileage', $mileage);
        }

        if ($status = request('status')) {
            $query->where('status', $status);
        }

        return $query->select([
            'vin',
            'brand',
            'model',
            'color_interior',
            'color_exterior',
            'model_year',
            'engine',
            'configuration',
            'engine_number',
            'arrival_date',
            'mileage',
            'status',
            'comment'
        ])->get();
    }

    public function headings(): array
    {
        return [
            'VIN',
            'Brand',
            'Model',
            'Color Interior',
            'Color Exterior',
            'Model Year',
            'Engine',
            'Configuration',
            'Engine Number',
            'Arrival Date',
            'Mileage',
            'Status',
            'Comment'
        ];
    }
}
