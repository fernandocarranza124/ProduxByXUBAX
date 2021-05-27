<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Khill\Lavacharts\Laravel\LavachartsFacade;
use Khill\Lavacharts\Lavacharts;
use Lava;

class SeemetrixController extends Controller
{
    public function getDataFromSeemetrix($idUserSeemetrix,$keyUserSeemetrix, $DevicesIds, $fechaInicial, $fechaFinal)
    {
        
        $client = new Client();
        $analiticos = new Collection();
        $fechaInicial = $this->FechaToFormat($fechaInicial);
        
        $fechaFinal = $this->FechaToFormat($fechaFinal);
        foreach ($DevicesIds as $id) {
            $url = "https://analytics.3divi.ru/api/v2/statistics/user/".$idUserSeemetrix."/devices/dates/?key=".$keyUserSeemetrix."&tzo=0&dt_format=YYYY-MM-DD HH&b=".$fechaInicial."&e=2021/05/21%2000:00:00&d=".$id;
            // dd($url);
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
            $analiticos->push($responseBody);
        }
        $this->makeGraphs($analiticos);
        return $analiticos;
        
    }
    public function makeGraphs($data)
    {
        $this->otsVSwatchers($data);
    }
    public function otsVSwatchers($data)
    {
        $totalOTS=0;
        $totalWatchers=0;
        $ImpactsdaysOfWeek = [["Dom", 0 ,0],["Lun", 0 ,0],["Mar", 0 ,0],["Mie", 0 ,0],["Jue", 0 ,0],["Vie", 0 ,0],["Sab", 0 ,0],];
        $TimesdaysOfWeek = [["Dom", 0 ,0],["Lun", 0 ,0],["Mar", 0 ,0],["Mie", 0 ,0],["Jue", 0 ,0],["Vie", 0 ,0],["Sab", 0 ,0]];
        $ImpactsHoursOfDay =  [["00", 0 ,0],["01", 0 ,0],["02", 0 ,0],["03", 0 ,0],["04", 0 ,0],["05", 0 ,0],["06", 0 ,0],["07", 0 ,0],["08", 0 ,0],["09", 0 ,0],["10", 0 ,0],["11", 0 ,0],["12", 0 ,0],["13", 0 ,0],["14", 0 ,0],["15", 0 ,0],["16", 0 ,0],["17", 0 ,0],["18", 0 ,0],["19", 0 ,0],["20", 0 ,0],["21", 0 ,0],["22", 0 ,0],["23", 0 ,0],["24", 0 ,0]];
        // dd($data);
        foreach ($data as $key) {
            // dd($key);
            $totalOTS = $totalOTS + $key->data->ots;
            $totalWatchers = $totalWatchers + $key->data->v;
            foreach ($key->data->o as $device) {
                foreach($device->o as $fecha){
                // dd($fecha);
                $date = (substr($fecha->n,0,10));
                $time = (substr($fecha->n,11,14));
                $fechaCarbon = Carbon::parse($date);
                $diaDeSemana = ($fechaCarbon->dayOfWeek);
                $horaDelDia = (Int)$time;
                // Actualiza ODP
                $ImpactsdaysOfWeek[$diaDeSemana][1] = $ImpactsdaysOfWeek[$diaDeSemana][1] + $fecha->ots;
                // Actualiza impactos
                $ImpactsdaysOfWeek[$diaDeSemana][2] = $ImpactsdaysOfWeek[$diaDeSemana][2] + $fecha->v;
                // Actualiza tiempos de ODP
                $TimesdaysOfWeek[$diaDeSemana][1] = $TimesdaysOfWeek[$diaDeSemana][1] + ($fecha->otsd/1000);
                // Actualiza tiempos de imactos
                $TimesdaysOfWeek[$diaDeSemana][2] = $TimesdaysOfWeek[$diaDeSemana][2] + ($fecha->vd/1000);
                // Actualiza ODP por hora
                $ImpactsHoursOfDay[$horaDelDia][1] = $ImpactsHoursOfDay[$horaDelDia][1] + $fecha->ots;
                // Actualiza impactos por hora
                $ImpactsHoursOfDay[$horaDelDia][2] = $ImpactsHoursOfDay[$horaDelDia][2] + $fecha->v;
                }
            }
            
        }
        // dd($key);
        $this->SimpleVersus($totalOTS, $totalWatchers);
        $this->EstructuredTable($ImpactsHoursOfDay);
    }
    public function EstructuredTable($data)
    {
        $grafica = Lava::DataTable();
        $grafica->addDateTimeColumn('Hour')->setDateTimeFormat('H');
            $grafica->setDateTimeFormat('H');
            $grafica->addTimeOfDayColumn('Hora');
            // $grafica->addRow(['',$totalOTS, $totalWatchers]);
                $grafica = Lava::DataTable();
                    
                    $index = 0;
                    foreach ($data as $row) {
                        $index++;
                        $grafica->addNumberColumn($row[0]);
                    }
                    
                    $DaysMap = [
                        0 => '00',1 => '01',2 => '02',3 => '03',4 => '04',5 => '05',6 => '06',
                        7 => '7',8 => '8',9 => '9',10 => '10',11 => '11',12 => '12',13 => '13',
                        14 => '14',15 => '15',16 => '16',17 => '17',18 => '18',19 => '19',20 => '20',
                        21 => '21',22 => '22',23 => '23',
                    ];
                    $indexWeekDay= 7;
                    // $grafica->addRow([]);
                    dd($grafica);
                    
    }
    public function SimpleVersus($totalOTS, $totalWatchers)
    {
        $grafica = Lava::DataTable();
            $grafica->addStringColumn('Impactos');
            $grafica->setDateTimeFormat('l');
            $grafica->addNumberColumn('Oportunidades de impacto');
            $grafica->addNumberColumn('Impactos');
            $grafica->addRow(['',$totalOTS, $totalWatchers]);
        $this->makeColumnChart('ODP - Impactos comparación', $grafica, ['#254E7B','#337AB7'],'impactos');
            
    }
    public function FechaToFormat($fecha)
    {
        $fecha = Carbon::parse($fecha)->subDay(1)->toDateTimeString();
        $fecha = (str_replace("-","/",$fecha,$i));
        return $fecha;
    }
    public function makeColumnChart($nombre, $grafica, $colores, $displayVaxis)
    {
        Lava::ColumnChart($nombre, $grafica, [
            // 'title' => 'Productos con mayor interacción',
            'colors'=> $colores,
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ],
            'vAxis' => [
                'display'=>$displayVaxis
            ],
            
            'height' => 300,
            'pieSliceText' => 'value',
            'is3D'   => true,
            'slices' => [
                
            ],
            'legend' => ['position'=> 'top', 'maxLines'=> 3],
        ]);
    }

    
}
