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
        $ImpactsdaysOfWeek = [["Nombre" => "ODI","Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,"Dom"=>0],
                                ["Nombre" => "Impactos","Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,"Dom"=>0]];
        $ImpactsHoursOfDay =  [["Nombre" => 'ODI', "00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,
        "10"=>0,"11"=>0,"12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,
        "20"=>0,"21"=>0,"22"=>0,"23"=>0],
        ["Nombre" => 'Impactos', "00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,
        "10"=>0,"11"=>0,"12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,
        "20"=>0,"21"=>0,"22"=>0,"23"=>0]];

        $TimeDuringImpactsdaysOfWeek = [["Nombre" => "ODI","Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,"Dom"=>0],
                                ["Nombre" => "Impactos","Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,"Dom"=>0]];
        $TimeDuringImpactsHoursOfDay =  [["Nombre" => 'ODI', "00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,
        "10"=>0,"11"=>0,"12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,
        "20"=>0,"21"=>0,"22"=>0,"23"=>0],
        ["Nombre" => 'Impactos', "00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,
        "10"=>0,"11"=>0,"12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,
        "20"=>0,"21"=>0,"22"=>0,"23"=>0]];
        // dd($ImpactsHoursOfDay);
        foreach ($data as $key) {
            // dd($key);
            $totalOTS = $totalOTS + $key->data->ots;
            $totalWatchers = $totalWatchers + $key->data->v;
            $totalOTSd = $totalOTS + $key->data->otsd;
            $totalWatchersd = $totalWatchers + $key->data->vd;
            foreach ($key->data->o as $device) {
                foreach($device->o as $fecha){
                // dd($fecha);
                $date = (substr($fecha->n,0,10));
                $time = (substr($fecha->n,11,14));
                $fechaCarbon = Carbon::parse($date);
                $diaDeSemana = ($fechaCarbon->dayOfWeek);
                $diaDeSemana = $this->getDayOfTheWeekInNumber($diaDeSemana);
                $horaDelDia = (Int)$time;
                // Actualiza ODI
                $ImpactsdaysOfWeek[0][$diaDeSemana] = $ImpactsdaysOfWeek[0][$diaDeSemana] + $fecha->ots;
                // Actualiza impactos
                $ImpactsdaysOfWeek[1][$diaDeSemana] = $ImpactsdaysOfWeek[1][$diaDeSemana] + $fecha->v;
                
                // Actualiza ODI por hora
                $ImpactsHoursOfDay[0][$horaDelDia] = $ImpactsHoursOfDay[0][$horaDelDia] + $fecha->ots;
                // Actualiza impactos por hora
                $ImpactsHoursOfDay[1][$horaDelDia] = $ImpactsHoursOfDay[1][$horaDelDia] + $fecha->v;

                // Duracion
                // //////////////////////////// //
                // Actualiza ODI
                $TimeDuringImpactsdaysOfWeek[0][$diaDeSemana] = $TimeDuringImpactsdaysOfWeek[0][$diaDeSemana] + $fecha->otsd;
                // Actualiza impactos
                $TimeDuringImpactsdaysOfWeek[1][$diaDeSemana] = $TimeDuringImpactsdaysOfWeek[1][$diaDeSemana] + $fecha->vd;
                
                // Actualiza ODI por hora
                $TimeDuringImpactsHoursOfDay[0][$horaDelDia] = $TimeDuringImpactsHoursOfDay[0][$horaDelDia] + $fecha->otsd;
                // Actualiza impactos por hora
                $TimeDuringImpactsHoursOfDay[1][$horaDelDia] = $TimeDuringImpactsHoursOfDay[1][$horaDelDia] + $fecha->vd;
                }
            }
            
        }
        // dd($key);
        $this->SimpleVersus($totalOTS, $totalWatchers,'Cantidades de ODI - Impactos',['#254E7B','#337AB7']);
        $this->DiasDeLaSemanaGrafica($ImpactsdaysOfWeek,'Cantidades de impactos por Dia','Tiempos Dia',['#254E7B','#337AB7']);
        $this->HorasDelDia($ImpactsHoursOfDay,'Cantidad de impactos por hora',['#254E7B','#337AB7']);

        $this->SimpleVersus($totalOTSd, $totalWatchersd,'Tiempo de atencion ODI - Impactos',['#2d6b22','#8AB446']);
        #2D6B22
        $this->DiasDeLaSemanaGrafica($TimeDuringImpactsdaysOfWeek,'Tiempo de impactos por dia de la semana','Tiempos Dia',['#2d6b22','#8AB446']);
        $this->HorasDelDia($TimeDuringImpactsHoursOfDay, 'Duracion de impactos por hora',['#2d6b22','#8AB446']);
    }
    public function getDayOfTheWeekInNumber($diaDeSemanaEnString)
    {
        // dd($diaDeSemanaEnString);
        switch ($diaDeSemanaEnString) {
            case 0:
                return "Dom";
                break;
            case 1:
                return "Lun";
                break;
            case 2:
                return "Mar";
                break;
            case 3:
                return "Mie";
                break;
            case 4:
                return "Jue";
                break;
            case 5:
                return "Vie";
                break;
            case 6:
                return "Sab";
                break;                                
            default:
            return "Lun";
                break;
        }
    }
    public function DiasDeLaSemanaGrafica($rows,$nombre,$label,$colores){
        // dd($rows);
        $grafica = Lava::DataTable();
            $grafica->addStringColumn('Day');
            $index = 0;
            foreach ($rows as $row) {
                $index++;
                $grafica->addNumberColumn($row['Nombre']);
            }
            $weekMap = [
                0 => 'Lun',
                1 => 'Mar',
                2 => 'Mie',
                3 => 'Jue',
                4 => 'Vie',
                5 => 'Sab',
                6 => 'Dom',
            ];
            $indexWeekDay= 0;
            foreach ($weekMap as $day) {
                $arreglo = [$day];    
                for ($i=0; $i < $index ; $i++) { 
                    array_push($arreglo, $rows[$i][$weekMap[$indexWeekDay]]);   
                }
                $indexWeekDay++;
                $grafica->addRow($arreglo);
            }
            $this->makeColumnChart($nombre, $grafica, $colores,$label);
        }
    public function HorasDelDia($rows,$nombreGrafica,$colores){
        $grafica = Lava::DataTable();
            $grafica->addDateTimeColumn('Hour')->setDateTimeFormat('H');
            $index = 0;
            foreach ($rows as $row) {
                $index++;
                $grafica->addNumberColumn($row['Nombre']);
            }
            
            $DaysMap = [
                // 0 => '00',1 => '01',2 => '02',3 => '03',4 => '04',5 => '05',6 => '06',
                7 => '07',8 => '08',9 => '09',10 => '10',11 => '11',12 => '12',13 => '13',
                14 => '14',15 => '15',16 => '16',17 => '17',18 => '18',19 => '19',20 => '20',
                21 => '21',22 => '22',23 => '23',
            ];
            $indexWeekDay= 7;
            foreach ($DaysMap as $day) {
                $arreglo = [$day];    
                for ($i=0; $i < $index ; $i++) { 
                    array_push($arreglo, $rows[$i][$DaysMap[$indexWeekDay]]);   
                }

                $indexWeekDay++;
                $grafica->addRow($arreglo);
            
            }
            $this->makeColumnChart($nombreGrafica, $grafica, $colores,'impactos');
        }
    
                    
    
    public function SimpleVersus($totalOTS, $totalWatchers,$nombreGrafica, $colores)
    {
        $grafica = Lava::DataTable();
            $grafica->addStringColumn('Impactos');
            $grafica->setDateTimeFormat('l');
            $grafica->addNumberColumn('Oportunidades de impacto');
            $grafica->addNumberColumn('Impactos');
            $grafica->addRow(['',$totalOTS, $totalWatchers]);
        $this->makeColumnChart($nombreGrafica, $grafica, $colores,'impactos');
            
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
