<?php

namespace App\Imports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SalesImport implements WithMultipleSheets 
{
    public function sheets(): array
    {
        return [
            1 => new SecondSheetImport(),
        ];
    }
}

