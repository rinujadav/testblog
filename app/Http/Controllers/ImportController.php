<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CustomersImport;
use App\Imports\SalesImport;
use App\Imports\ProductsImport;
use App\Imports\EmployeesImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function customers_import() {
        $import = new CustomersImport();
        Excel::import($import, public_path('data/TestData.xlsx'));
        return "Imported Successfully.";
    }

    public function sales_import() {
        $import = new SalesImport();
        Excel::import($import, public_path('data/TestData.xlsx'));
        return "Imported Successfully.";
    }

    public function products_import() {
        $import = new ProductsImport();
        Excel::import($import, public_path('data/TestData.xlsx'));
        return "Imported Successfully.";
    }

    public function employees_import() {
        $import = new EmployeesImport();
        Excel::import($import, public_path('data/TestData.xlsx'));
        return "Imported Successfully.";
    }
}
