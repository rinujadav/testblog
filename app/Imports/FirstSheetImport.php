<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FirstSheetImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if($row[0] > 0) {
                Customer::create([
                    'id'            => $row[0],
                    'first_name'    => $row[1],
                    'last_name'     => $row[2],
                    'full_name'     => $row[3],
                    'email'         => $row[4],
                    'gender'        => $row[5],
                    'street'        => $row[6],
                    'city'          => $row[7],
                    'created_at'    => now()
                ]);
            }
        }
    }
}