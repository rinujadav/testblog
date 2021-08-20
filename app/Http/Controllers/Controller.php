<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getDailyGain() {
        $dt = Carbon::now();
        $login_username = 'support@algocapitalfx.com';
        $login_passwrord = 'Billions100$$';
        $login_url = "https://www.myfxbook.com/api/login.json?email=" . $login_username ."&password=" . $login_passwrord;
        $login_json = json_decode(file_get_contents($login_url), true);
        $account = [];
        if(!$login_json['error'] && $login_json['session'] != '') {
            $session = $login_json['session'];
            $id = '3353768';
            $start = '2021-01-01';
            $end = $dt->toDateString();
            // $url = "https://www.myfxbook.com/api/get-daily-gain.json?session=" . $session . "&id=" . $id . "&start=" . $start . "&end=" . $end;
            // $url = "https://www.myfxbook.com/api/get-data-daily.json?session=" . $session . "&id=" . $id . "&start=" . $start . "&end=" . $end;
            $url = "https://www.myfxbook.com/api/get-my-accounts.json?session=" . $session;
            $json = json_decode(file_get_contents($url), true);
            foreach ($json['accounts'] as $key => $value) {
                if($value['name'] == 'OMEGA') {
                    $account[$key] = $value;    
                }
            }
            return $account[0]['gain'];
        }
    }
}
