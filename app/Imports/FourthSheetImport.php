<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;

class FourthSheetImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if($row[0] > 0) {
                Employee::create([
                    'id'        => $row[0],
                    'name'      => $row[1],
                    'created_at'=> now()
                ]);
            }
        }
    }
}