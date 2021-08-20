<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;

class ThirdSheetImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if($row[0] > 0) {
                Product::create([
                    'id'        => $row[0],
                    'name'      => $row[1],
                    'price'     => $row[2],
                    'created_at'=> now()
                ]);
            }
        }
    }
}