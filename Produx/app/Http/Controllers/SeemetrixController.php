<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SeemetrixController extends Controller
{
    public function getDataFromSeemetrix($idUserSeemetrix,$keyUserSeemetrix, $DevicesIds, $fechaInicial, $fechaFinal)
    {
        $client = new Client();
        $analiticos = new Collection();
        $fechaInicial = $this->FechaToFormat($fechaInicial);
        $fechaFinal = $this->FechaToFormat($fechaFinal);
        foreach ($DevicesIds as $id) {
            $url = "https://analytics.3divi.ru/api/v2/statistics/user/".$idUserSeemetrix."/devices/dates/?key=".$keyUserSeemetrix."&tzo=0&b=".$fechaInicial."&e=2021/05/21%2000:00:00&d=".$id;
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
            $analiticos->push($responseBody);
        }
        return $analiticos;
        
    }
    public function FechaToFormat($fecha)
    {
        $fecha = Carbon::parse($fecha)->toDateTimeString();
        $fecha = (str_replace("-","/",$fecha,$i));
        return $fecha;
    }
    
}
