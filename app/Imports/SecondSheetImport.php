<?php

namespace App\Imports;

use App\Models\Sale;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;

class SecondSheetImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if($row[0] > 0) {
                Sale::create([
                    'id'            => $row[0],
                    'product_name'  => $row[1],
                    'date'          => date('Y-m-d', strtotime($row[2])),
                    'sales_person'  => $row[3],
                    'customer_name' => $row[4],
                    'created_at'    => now()
                ]);
            }
        }
    }
}