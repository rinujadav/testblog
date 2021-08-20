<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EmployeesImport implements WithMultipleSheets 
{
    public function sheets(): array
    {
        return [
            3 => new FourthSheetImport(),
        ];
    }
}

