<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Temp;

class TempController extends Controller
{
    public function log($request, $response, $args)
    {
        $ip = $_POST['ip'];

        $temp = Temp::firstOrCreate(['ip' => $ip]);
    }

    public function delete($request, $response, $args)
    {
        $ip = $_POST['ip'];

        $temp = Temp::where('ip', $ip)->delete();

        return $temp;
    }
}

