<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Customer::select('name', 'phone', 'email', 'address')->get();
    }

    public function headings(): array
    {
        return ['Nom', 'Téléphone', 'Email', 'Adresse'];
    }
}
