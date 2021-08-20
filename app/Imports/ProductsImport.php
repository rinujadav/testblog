<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductsImport implements WithMultipleSheets 
{
    public function sheets(): array
    {
        return [
            2 => new ThirdSheetImport(),
        ];
    }
}

