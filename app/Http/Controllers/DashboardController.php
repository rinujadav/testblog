<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Admin\Accounts;
use Carbon\Carbon;
use Auth;
use DB;

class DashboardController extends Controller
{
  // Dashboard - Analytics
  public function dashboardAnalytics()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('/content/dashboard/index', ['pageConfigs' => $pageConfigs]);
  }

  //Get Sales data from Myfxbook API
  public function sales_data(Request $request) {
      $dates          = array();
      $total          = array();
      $start          = $request->start_date;
      $end            = $request->end_date;
      if($start == null && $end == null) {
        $sales = DB::table('sales')
                ->whereMonth(
                    'date', '=', Carbon::now()->subMonth()->month
                )
                ->select('date', DB::raw('count(*) as total'))
                ->groupBy('date')
                ->get();
        foreach ($sales as $key => $sale) {
          $dates[] = $sale->date;
          $total[] = $sale->total;
        }
        return response()->json([
          'dates' => $dates,
          'sales' => $total
        ]);    
      }
      elseif($start != null && $end != null) {
        if($start < $end) {
          $sales = DB::table('sales')
                  ->whereBetween('date', [$start, $end])
                  ->select('date', DB::raw('count(*) as total'))
                  ->groupBy('date')
                  ->get();
          foreach ($sales as $key => $sale) {
            $dates[] = $sale->date;
            $total[] = $sale->total;
          }
          return response()->json([
            'dates' => $dates,
            'sales' => $total
          ]);
        }
        else {
          return;
        }
      }
      else {
        return;
      }
  }
}
