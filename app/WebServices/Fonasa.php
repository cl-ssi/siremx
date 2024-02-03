<?php

namespace App\WebServices;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use SopaClient;

class Fonasa extends Model
{
    use HasFactory;

    public static function find($run) {
        $run = strtoupper(str_replace(['.', ','], '', trim($run)));
        list($id, $dv) = explode('-', $run);

        /** Calculo del DV para comprobar que el run sea válido */
        $s = 1;
        $m = 0;
        $rut = $id;
        while ($rut !== 0) {
            $s = ($s + ($rut % 10) * (9 - $m++ % 6)) % 11;
            $rut = (int)($rut / 10);
        }

        if($dv != chr($s ? $s + 47 : 75)) {
            return json_decode('{ "message" : "Run inválido" }');
        }
        else {
            $url = env('WSSSI_URL') . "/fonasa?run=$id&dv=$dv";
            $response = Http::get($url);
            return json_decode($response);
        }
    }
}
