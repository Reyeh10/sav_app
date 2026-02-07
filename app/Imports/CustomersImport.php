<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomersImport implements ToModel
{
    public function model(array $row)
    {
        return new Customer([
            'name'    => $row[0],
            'phone'   => $row[1],
            'email'   => $row[2] ?? null,
            'address' => $row[3] ?? null,
        ]);
    }
}
