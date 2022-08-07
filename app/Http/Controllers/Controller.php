<?php

namespace App\Http\Controllers;

use App\Models\ZipCode;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function zip_code($code)
    {
        if(Cache::has($code))
            return Cache::get($code);

        $obj = ZipCode::with('federal_entity','municipality','settlements','settlements.settlement_type')->find($code);
        $json= json_encode($obj,JSON_UNESCAPED_UNICODE);
        Cache::put($code,$json, 3600 * 24);
        return $json;
    }
}
