<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // ✅ Sécurité : ignorer ligne vide
        if (empty($row['client'])) {
            return null;
        }

        return new Customer([
            'name'    => $row['client'],
            'phone'   => $row['telephone'] ?? null,
            'email'   => $row['email'] ?? null,
            'address' => $row['adresse'] ?? null,
        ]);
    }
}
