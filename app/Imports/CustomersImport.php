<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CustomersImport implements WithMultipleSheets 
{
    public function sheets(): array
    {
        return [
            new FirstSheetImport()
        ];
    }
}
