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
    // dd($fechaFinal);
        $client = new Client();
        $analiticos = new Collection();
        $demograficos = new Collection();
        $edades = new Collection();
        $semanal = new Collection();
        $emociones = new Collection();
        $infosCards = new Collection();
        $fechaInicial = $this->FechaToFormat($fechaInicial);
        
        $fechaFinal = $this->FechaToFormat($fechaFinal);
        foreach ($DevicesIds as $id) {
            $url = "https://analytics.3divi.ru/api/v2/statistics/user/".$idUserSeemetrix."/devices/dates/?key=".$keyUserSeemetrix."&tzo=0&dt_format=YYYY-MM-DD HH&b=".$fechaInicial."&e=2021/05/21%2000:00:00&d=".$id;
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
            $analiticos->push($responseBody);
            // ////////////////
            $url = "https://analytics.3divi.ru/api/v2/statistics/user/".$idUserSeemetrix."/devices/genders/ages/emotions/dates/?key=".$keyUserSeemetrix."&tzo=0&dt_format=YYYY-MM-DD HH&b=".$fechaInicial."&e=2021/05/21%2000:00:00&d=".$id;
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
            $demograficos->push($responseBody);
        
            // ////////////////
            $url = "https://analytics.3divi.ru/api/v2/statistics/user/".$idUserSeemetrix."/genders/ages/?key=".$keyUserSeemetrix."&tzo=0&dt_format=YYYY-MM-DD HH&b=".$fechaInicial."&e=2021/05/21%2000:00:00&d=".$id;
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
            $infosCards->push($responseBody);
            // ////////////////
            $url = "https://analytics.3divi.ru/api/v2/statistics/user/".$idUserSeemetrix."/ages/?key=".$keyUserSeemetrix."&tzo=0&dt_format=YYYY-MM-DD HH&b=".$fechaInicial."&e=2021/05/21%2000:00:00&d=".$id;
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
            $edades->push($responseBody);
            // ////////////////
            $url = "https://analytics.3divi.ru/api/v2/statistics/user/".$idUserSeemetrix."/dates/genders/ages/?key=".$keyUserSeemetrix."&tzo=0&dt_format=YYYY-MM-DD HH&b=".$fechaInicial."&e=2021/05/21%2000:00:00&d=".$id;
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
            $semanal->push($responseBody);
            // ////////////////
            $url = "https://analytics.3divi.ru/api/v2/statistics/user/".$idUserSeemetrix."/emotions/genders/ages/?key=".$keyUserSeemetrix."&tzo=0&dt_format=YYYY-MM-DD HH&b=".$fechaInicial."&e=2021/05/21%2000:00:00&d=".$id;
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
            $emociones->push($responseBody);
        }
        $this->makeGraphs($analiticos, $demograficos, $emociones, $semanal);

        $infosCards = $this->makeInfoCards($infosCards, $edades);
        
            $analiticos->cards = $infosCards;
        return $analiticos;
        
    }
    public function makeInfoCards($infos, $edades)
    {
        // dd($infos);
        $EdadesPorGenero = 
            ['female'=>["kid"=>["v"=>0,"vd"=>0],"young"=>["v"=>0,"vd"=>0],"adult"=>["v"=>0,"vd"=>0],"old"=>["v"=>0,"vd"=>0],"undefined"=>["v"=>0,"vd"=>0]],
             'male'=>["kid"=>["v"=>0,"vd"=>0],"young"=>["v"=>0,"vd"=>0],"adult"=>["v"=>0,"vd"=>0],"old"=>["v"=>0,"vd"=>0],"undefined"=>["v"=>0,"vd"=>0]],
             'desconocido'=>["kid"=>["v"=>0,"vd"=>0],"young"=>["v"=>0,"vd"=>0],"adult"=>["v"=>0,"vd"=>0],"old"=>["v"=>0,"vd"=>0],"undefined"=>["v"=>0,"vd"=>0]],
            ];
        $femaleViews=($infos[0]->data->o[0]->v);
        $femaleViewsDuration=($infos[0]->data->o[0]->vd);
        $maleViews=($infos[0]->data->o[1]->v);
        $maleViewsDuration=($infos[0]->data->o[1]->vd);
        // dd($infos[0]->data->o);
        foreach ($infos[0]->data->o as $genero) {
            switch ($genero->n) {
                case "female":
                    $indice = "female";       
                    break;
                case "male":
                    $indice = "male";
                    break;
                default:
                    $indice = 'desconocido';
                    break;
            }
            foreach ($genero->o as $edad) {
                $EdadesPorGenero[$indice][$edad->n]['v'] = $EdadesPorGenero[$indice][$edad->n]['v'] + $edad->v;
                $EdadesPorGenero[$indice][$edad->n]['vd'] = $EdadesPorGenero[$indice][$edad->n]['vd'] + $edad->vd;
            }
        }
        // dd($edades);
        $AgesData = [
            ["name" => "kid","Nombre" => "Niño","cantidad" => 0],
            ["name" => "young","Nombre" => "Joven","cantidad" => 0],
            ["name" => "adult","Nombre" => "Adulto","cantidad" => 0],
            ["name" => "senior","Nombre" => "Anciano","cantidad" => 0],
        ];
        $mayorgrupo = ["grupo"=>"null", "cantidad"=>0];
        $mayorAtencion  = ["grupo"=>"null", "cantidad"=>0];
        foreach ($edades[0]->data->o as $edad ) {
            
            // foreach ($AgesData as $guardarEdad) {
            for ($i=0; $i <count($AgesData) ; $i++) { 
                    # code...
                if($edad->n == $AgesData[$i]['name']){
                    $AgesData[$i]['cantidad'] = $edad->v;
                    if ($AgesData[$i]['cantidad'] > $mayorgrupo['cantidad']) {
                        $mayorgrupo['cantidad'] = $AgesData[$i]['cantidad'];
                        $mayorgrupo['grupo'] = $AgesData[$i]['Nombre'];
                    }
                    
                }
            }
        }
        

        
        $femaleViews = $EdadesPorGenero["female"]["kid"]['v'] + $EdadesPorGenero["female"]["young"]['v'] +$EdadesPorGenero["female"]["adult"]['v'] + $EdadesPorGenero["female"]["old"]['v'];
        $maleViews = $EdadesPorGenero["male"]["kid"]['v'] + $EdadesPorGenero["male"]["young"]['v'] +$EdadesPorGenero["male"]["adult"]['v'] + $EdadesPorGenero["male"]["old"]['v'];
        $femaleViewsDuration = $EdadesPorGenero["female"]["kid"]['vd'] + $EdadesPorGenero["female"]["young"]['vd'] +$EdadesPorGenero["female"]["adult"]['vd'] + $EdadesPorGenero["female"]["old"]['vd'];
        $maleViewsDuration = $EdadesPorGenero["male"]["kid"]['vd'] + $EdadesPorGenero["male"]["young"]['vd'] +$EdadesPorGenero["male"]["adult"]['vd'] + $EdadesPorGenero["male"]["old"]['vd'];
        $totalViews = $femaleViews + $maleViews;
        
        $mayorgrupo["cantidad"] =  (round($mayorgrupo['cantidad'] * 100 / $totalViews));
        $topDemograficGroup = $mayorgrupo['grupo']." ".$mayorgrupo['cantidad'];
        
        $topAttentionTime = "Adulto 45.2";

        $this->makeGenderSplitGraph($maleViews, $femaleViews);
        $this->makeAgeSplitGraph($AgesData);
        $infosCards = new Collection();
        $infosCards->femaleViews = round(($femaleViews)*(100)/($totalViews),1);
        $infosCards->maleViews = round(($maleViews)*(100)/($totalViews),1);
        $infosCards->maleAverageAttention = round(($maleViewsDuration/$maleViews)/1000);
        $infosCards->femaleAverageAttention = round(($femaleViewsDuration/$femaleViews)/1000);
        $infosCards->topDemograficGroup = $topDemograficGroup;
        $infosCards->topAttentionTime = $topAttentionTime;
        // dd($infosCards);

        return $infosCards;
    }
    public function makeAgeSplitGraph($data)
    {
        $grafica = Lava::DataTable();
        $grafica->addStringColumn('grupo');
        $grafica->addNumberColumn('cantidad');
        $grafica->addRow(["Impactos en infantes",$data[0]['cantidad']]);
        $grafica->addRow(["Impactos en jovenes",$data[1]['cantidad']]);        
        $grafica->addRow(["Impactos en adultos",$data[2]['cantidad']]);        
        $grafica->addRow(["Impactos en ancianos",$data[3]['cantidad']]);        
        $this->makeDonutChart('Comparacion de impactos por edad', $grafica, ['#739C6C','#B4D365','#7BA439','#2D6B22','#FFDFEE','#E98195','#CF0029','#7B000B'],'Comparacion de impactos por edad');
        // dd($grafica);
    }
    public function makeGenderSplitGraph($maleViews, $femaleViews){
        $grafica = Lava::DataTable();
            $grafica->addStringColumn('Day');
            $index = 0;
            $grafica->setDateTimeFormat('d');
            $grafica->addNumberColumn('En hombre');
            $grafica->addRow(["Impactos en hombres",$maleViews]);
            $grafica->addRow(["Impactos en mujeres",$femaleViews]);
            // $grafica->addRow($femaleViews);
            // dd($grafica);
            
            $this->makeDonutChart('Comparacion de impactos por género', $grafica, ['#85C1E5','#E98195','#337AB7','#254E7B','#FFDFEE','#E98195','#CF0029','#7B000B'],'Comparacion de impactos por género');
    }

    public function makeGraphs($data, $demograph, $emociones, $semanal)
    {
        $this->otsVSwatchers($data);
        $this->GenderEmotions($demograph, $semanal);
        $this->EmotionsSplit($emociones);
    }

    public function EmotionsSplit($emociones)
    {
        $SolamenteEmociones= [
            "angry" => ["Nombre"=> "Enojo", "cantidad"=>0], "happy" => ["Nombre"=> "Felicidad", "cantidad"=>0], "neutral" => ["Nombre"=> "Neutralidad", "cantidad"=>0], "surprise" => ["Nombre"=> "Sorpresa", "cantidad"=>0], "undefined" => ["Nombre"=> "No definido", "cantidad"=>0]
        ];
        $EmocionesPorGenero = [
            "male"=>[
                "angry" => ["Nombre"=> "Enojo", "cantidad"=>0], "happy" => ["Nombre"=> "Felicidad", "cantidad"=>0], "neutral" => ["Nombre"=> "Neutral", "cantidad"=>0], "surprise" => ["Nombre"=> "Sorpresa", "cantidad"=>0], "undefined" => ["Nombre"=> "No definido", "cantidad"=>0]
            ],
            "female"=>[
                "angry" => ["Nombre"=> "Enojo", "cantidad"=>0], "happy" => ["Nombre"=> "Felicidad", "cantidad"=>0], "neutral" => ["Nombre"=> "Neutral", "cantidad"=>0], "surprise" => ["Nombre"=> "Sorpresa", "cantidad"=>0], "undefined" => ["Nombre"=> "No definido", "cantidad"=>0]
            ],
        ];
        $EmocionesPorEdad = [
            "kid" =>[
                "angry" => ["Nombre"=> "Enojo", "cantidad"=>0], "happy" => ["Nombre"=> "Felicidad", "cantidad"=>0], "neutral" => ["Nombre"=> "Neutral", "cantidad"=>0], "surprise" => ["Nombre"=> "Sorpresa", "cantidad"=>0], "undefined" => ["Nombre"=> "No definido", "cantidad"=>0]
            ],
            "young" =>[
                "angry" => ["Nombre"=> "Enojo", "cantidad"=>0], "happy" => ["Nombre"=> "Felicidad", "cantidad"=>0], "neutral" => ["Nombre"=> "Neutral", "cantidad"=>0], "surprise" => ["Nombre"=> "Sorpresa", "cantidad"=>0], "undefined" => ["Nombre"=> "No definido", "cantidad"=>0]
            ],
            "adult" =>[
                "angry" => ["Nombre"=> "Enojo", "cantidad"=>0], "happy" => ["Nombre"=> "Felicidad", "cantidad"=>0], "neutral" => ["Nombre"=> "Neutral", "cantidad"=>0], "surprise" => ["Nombre"=> "Sorpresa", "cantidad"=>0], "undefined" => ["Nombre"=> "No definido", "cantidad"=>0]
            ],
            "old" =>[
                "angry" => ["Nombre"=> "Enojo", "cantidad"=>0], "happy" => ["Nombre"=> "Felicidad", "cantidad"=>0], "neutral" => ["Nombre"=> "Neutral", "cantidad"=>0], "surprise" => ["Nombre"=> "Sorpresa", "cantidad"=>0], "undefined" => ["Nombre"=> "No definido", "cantidad"=>0]
            ],
            "undefined" =>[
                "angry" => ["Nombre"=> "Enojo", "cantidad"=>0], "happy" => ["Nombre"=> "Felicidad", "cantidad"=>0], "neutral" => ["Nombre"=> "Neutral", "cantidad"=>0], "surprise" => ["Nombre"=> "Sorpresa", "cantidad"=>0], "undefined" => ["Nombre"=> "No definido", "cantidad"=>0]
            ],
        ];
        // dd($EmocionesPorEdad);
        foreach ($emociones[0]->data->o as $emocion) {
            $SolamenteEmociones[$emocion->n]["cantidad"] = $emocion->v;
             foreach ($emocion->o as $genero) {
                $EmocionesPorGenero[$genero->n][$emocion->n]["cantidad"] = $genero->v;
                foreach ($genero->o as $edad) {
                    $EmocionesPorEdad[$edad->n][$emocion->n]["cantidad"] = $EmocionesPorEdad[$edad->n][$emocion->n]["cantidad"] + $edad->v;
                }
             }
        }
        
            // dd($EmocionesPorEdad);    
        $this->makeEmotionsSplitGraph($SolamenteEmociones);
        $this->makeEmotionsByGenderGraph($EmocionesPorGenero);
        $this->makeEmotionsByAgeGraph($EmocionesPorEdad);
        
    }

    public function makeEmotionsSplitGraph($SolamenteEmociones)
    {
        // dd($SolamenteEmociones);
        $grafica = Lava::DataTable();
        $grafica->addStringColumn('Emocion');
        $grafica->addNumberColumn('cantidad');
        foreach ($SolamenteEmociones as $emocion) {
            if($emocion["Nombre"] != "No definido"){
                $grafica->addRow([$emocion["Nombre"], $emocion["cantidad"]]);
            }
        }
        $this->makeDonutChart('Emociones', $grafica, ["#D05F3D",'#ACD864','#A5D1E5','#E97595','#7B000B','#FFDFEE','#E98195','#CF0029','#7B000B'],'Emociones');
    }
    public function makeEmotionsByGenderGraph($EmocionesPorGenero)
    {
        $grafica = Lava::DataTable();
        $grafica->addStringColumn('Genero');
        $grafica->addNumberColumn('Neutralidad');
        $grafica->addNumberColumn('Felicidad');
        $grafica->addNumberColumn('Enojo');
        $grafica->addNumberColumn('Sorpresa');
// dd($EmocionesPorGenero);
        $grafica->addRow(["Hombre",$EmocionesPorGenero["male"]["neutral"]['cantidad'],$EmocionesPorGenero["male"]["happy"]['cantidad'],$EmocionesPorGenero["male"]["angry"]['cantidad'],$EmocionesPorGenero["male"]["surprise"]['cantidad']]);
        $grafica->addRow(["Mujer",$EmocionesPorGenero["female"]["neutral"]['cantidad'],$EmocionesPorGenero["female"]["happy"]['cantidad'],$EmocionesPorGenero["female"]["angry"]['cantidad'],$EmocionesPorGenero["female"]["surprise"]['cantidad']]);
        $this->makeColumnChart('Emociones por genero', $grafica, ["#A5D1E5",'#ACD864','#D05F3D','#E97595','#7B000B','#FFDFEE','#E98195','#CF0029','#7B000B'],'Emociones por genero');

    }
    public function makeEmotionsByAgeGraph($data)
    {
        $grafica = Lava::DataTable();
        $grafica->addStringColumn('Edad');
        $grafica->addNumberColumn('Neutralidad');
        $grafica->addNumberColumn('Felicidad');
        $grafica->addNumberColumn('Enojo');
        $grafica->addNumberColumn('Sorpresa');
        $grafica->addRow(["Infante",$data["kid"]["neutral"]['cantidad'],$data["kid"]["happy"]['cantidad'],$data["kid"]["angry"]['cantidad'],$data["kid"]["surprise"]['cantidad']]);
        $grafica->addRow(["Joven",$data["young"]["neutral"]['cantidad'],$data["young"]["happy"]['cantidad'],$data["young"]["angry"]['cantidad'],$data["young"]["surprise"]['cantidad']]);
        $grafica->addRow(["Adulto",$data["adult"]["neutral"]['cantidad'],$data["adult"]["happy"]['cantidad'],$data["adult"]["angry"]['cantidad'],$data["adult"]["surprise"]['cantidad']]);
        $grafica->addRow(["Anciano",$data["old"]["neutral"]['cantidad'],$data["old"]["happy"]['cantidad'],$data["old"]["angry"]['cantidad'],$data["old"]["surprise"]['cantidad']]);
        $this->makeColumnChart('Emociones por edad', $grafica, ["#A5D1E5",'#ACD864','#D05F3D','#E97595','#7B000B','#FFDFEE','#E98195','#CF0029','#7B000B'],'Emociones por edad');
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
    public function GenderEmotions($data, $semanal)
    {
        
        $genderAgeSplit = [
            ["Nombre" => "Hombre niño","cantidad" => 0],
            ["Nombre" => "Hombre joven","cantidad" => 0],
            ["Nombre" => "Hombre adulto","cantidad" => 0],
            ["Nombre" => "Hombre anciano","cantidad" => 0],
            ["Nombre" => "Mujer niña","cantidad" => 0],
            ["Nombre" => "Mujer joven","cantidad" => 0],
            ["Nombre" => "Mujer adulta","cantidad" => 0],
            ["Nombre" => "Mujer anciana","cantidad" => 0],
        ];

            foreach ($data as $key) {
                foreach ($key->data->o as $row) {
                    foreach ($row->o as $genero) {
                        switch ($genero->n) {
                            case 'male':
                                $indexEdad = 0;
                                foreach ($genero->o as $edad) {
                                    
                                    switch ($edad->n) {
                                        case 'kid':
                                            $genderAgeSplit[$indexEdad]['cantidad']=$edad->v;
                                            // dd($edad);
                                            break;
                                        case 'young':
                                            $genderAgeSplit[$indexEdad+1]['cantidad']=$edad->v;
                                            break;
                                        case 'adult':
                                            $genderAgeSplit[$indexEdad+2]['cantidad']=$edad->v;
                                            break;
                                        case 'senior':
                                            $genderAgeSplit[$indexEdad+3]['cantidad']=$edad->v;
                                            break;
                                        default:
                                            break;
                                    }
                                }
                                break;
                            case 'female':
                                $indexEdad = 4;
                                foreach ($genero->o as $edad) {
                                    switch ($edad->n) {
                                        case 'child':
                                            $genderAgeSplit[$indexEdad]['cantidad']=$edad->v;
                                            break;
                                        case 'young':
                                            $genderAgeSplit[$indexEdad+1]['cantidad']=$edad->v;
                                            break;
                                        case 'adult':
                                            $genderAgeSplit[$indexEdad+2]['cantidad']=$edad->v;
                                            break;
                                        case 'senior':
                                            $genderAgeSplit[$indexEdad+3]['cantidad']=$edad->v;
                                            break;
                                        default:
                                            break;
                                    }
                                }
                                break;
                            default:
                                break;
                        }
                        
                    }
                }
            }
            
            // //////////////////// dias de la semana
            $ImpactosDiasDeLaSemana = [
                ["Nombre" => "Hombre niño", "gender" => "male", "age"=>"kid","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,],
                ["Nombre" => "Hombre joven", "gender" => "male", "age"=>"young","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,], 
                ["Nombre" => "Hombre adulto", "gender" => "male", "age"=>"adult","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,], 
                ["Nombre" => "Hombre anciano", "gender" => "male", "age"=>"old","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,], 

                ["Nombre" => "Mujer niña", "gender" => "female", "age"=>"kid","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,],
                ["Nombre" => "Mujer joven", "gender" => "female", "age"=>"young","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,], 
                ["Nombre" => "Mujer adulto", "gender" => "female", "age"=>"adult","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,], 
                ["Nombre" => "Mujer anciano", "gender" => "female", "age"=>"old","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,], 
            ];
            $DuracionDiasDeLaSemana = [
                ["Nombre" => "Hombre niño", "gender" => "male", "age"=>"kid","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,],
                ["Nombre" => "Hombre joven", "gender" => "male", "age"=>"young","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,], 
                ["Nombre" => "Hombre adulto", "gender" => "male", "age"=>"adult","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,], 
                ["Nombre" => "Hombre anciano", "gender" => "male", "age"=>"young","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,], 

                ["Nombre" => "Mujer niño", "gender" => "female", "age"=>"kid","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,],
                ["Nombre" => "Mujer joven", "gender" => "female", "age"=>"young","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,], 
                ["Nombre" => "Mujer adulta", "gender" => "female", "age"=>"adult","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,], 
                ["Nombre" => "Mujer anciana", "gender" => "female", "age"=>"young","Dom"=>0,"Lun"=>0,"Mar"=>0,"Mie"=>0,"Jue"=>0,"Vie"=>0,"Sab"=>0,], 
            ];
            $interaccionesHorasDelDia = [
                ["Nombre" => "Hombre niño","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],
                ["Nombre" => "Hombre joven","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],
                ["Nombre" => "Hombre adulto","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],
                ["Nombre" => "Hombre anciano","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],

                ["Nombre" => "Mujer niño","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],
                ["Nombre" => "Mujer joven","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],
                ["Nombre" => "Mujer adulta","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],
                ["Nombre" => "Mujer anciana","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],
            ];
            $TiempoHorasDelDia = [
                ["Nombre" => "Hombre niño","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],
                ["Nombre" => "Hombre joven","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],
                ["Nombre" => "Hombre adulto","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],
                ["Nombre" => "Hombre anciano","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],

                ["Nombre" => "Mujer niño","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],
                ["Nombre" => "Mujer joven","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],
                ["Nombre" => "Mujer adulta","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],
                ["Nombre" => "Mujer anciana","00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,"18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0],
            ];

            // dd($ImpactosDiasDeLaSemana); 
            foreach ($semanal as $datos) {
                foreach ($datos->data->o as $dias) {
                    $dia = substr($dias->n,0 ,10 );
                    $hora = substr($dias->n, -2);
                    $diaCarbon = Carbon::parse($dia);
                    $diaCarbon = $diaCarbon->dayOfWeek;
                    // dd($dias);
                    foreach ($dias->o as $genero) {
                        foreach ($genero->o as $edad) {
                            for ($i=0; $i <count($ImpactosDiasDeLaSemana) ; $i++) { 
                                // dd($edad->n);
                                if($ImpactosDiasDeLaSemana[$i]["gender"] == $genero->n && $ImpactosDiasDeLaSemana[$i]["age"] == $edad->n){
                                    switch ($diaCarbon) {
                                        case 0:
                                            $ImpactosDiasDeLaSemana[$i]['Dom'] = $ImpactosDiasDeLaSemana[$i]['Dom'] + $edad->v;
                                            $DuracionDiasDeLaSemana[$i]['Dom'] = $DuracionDiasDeLaSemana[$i]['Dom'] + $edad->vd;
                                            break;
                                        case 1:
                                            $ImpactosDiasDeLaSemana[$i]['Lun'] = $ImpactosDiasDeLaSemana[$i]['Lun'] + $edad->v;
                                            $DuracionDiasDeLaSemana[$i]['Lun'] = $DuracionDiasDeLaSemana[$i]['Lun'] + $edad->vd;
                                            break;
                                        case 2:
                                            $ImpactosDiasDeLaSemana[$i]['Mar'] = $ImpactosDiasDeLaSemana[$i]['Mar'] + $edad->v;
                                            $DuracionDiasDeLaSemana[$i]['Mar'] = $DuracionDiasDeLaSemana[$i]['Mar'] + $edad->vd;
                                            break;
                                        case 3:
                                            $ImpactosDiasDeLaSemana[$i]['Mie'] = $ImpactosDiasDeLaSemana[$i]['Mie'] + $edad->v;
                                            $DuracionDiasDeLaSemana[$i]['Mie'] = $DuracionDiasDeLaSemana[$i]['Mie'] + $edad->vd;
                                            break;
                                        case 4:
                                            $ImpactosDiasDeLaSemana[$i]['Jue'] = $ImpactosDiasDeLaSemana[$i]['Jue'] + $edad->v;
                                            $DuracionDiasDeLaSemana[$i]['Jue'] = $DuracionDiasDeLaSemana[$i]['Jue'] + $edad->vd;
                                            break;
                                        case 5:
                                            $ImpactosDiasDeLaSemana[$i]['Vie'] = $ImpactosDiasDeLaSemana[$i]['Vie'] + $edad->v;
                                            $DuracionDiasDeLaSemana[$i]['Vie'] = $DuracionDiasDeLaSemana[$i]['Vie'] + $edad->vd;
                                            break;
                                        case 6:
                                            $ImpactosDiasDeLaSemana[$i]['Sab'] = $ImpactosDiasDeLaSemana[$i]['Sab'] + $edad->v;
                                            $DuracionDiasDeLaSemana[$i]['Sab'] = $DuracionDiasDeLaSemana[$i]['Sab'] + $edad->vd;
                                            break;                                
                                        default:
                                        $ImpactosDiasDeLaSemana[$i]['Dom'] = $ImpactosDiasDeLaSemana[$i]['Dom'] + $edad->v;
                                        $DuracionDiasDeLaSemana[$i]['Dom'] = $DuracionDiasDeLaSemana[$i]['Dom'] + $edad->vd;
                                            break;
                                    }
                                    switch ($hora) {
                                        case 0: 
                                            $interaccionesHorasDelDia[$i]['00'] =$interaccionesHorasDelDia[$i]['00'] +$edad->v ;     
                                            $TiempoHorasDelDia[$i]['00'] = $TiempoHorasDelDia[$i]['00'] + $edad->vd;     
                                            break;
                                        case 1:  
                                            $interaccionesHorasDelDia[$i]['01']=$interaccionesHorasDelDia[$i]['01'] + $edad->v;     
                                            $TiempoHorasDelDia[$i]['01']=$TiempoHorasDelDia[$i]['01'] + $edad->vd;     
                                            break;
                                        case 2:  
                                            $interaccionesHorasDelDia[$i]['02'] = $interaccionesHorasDelDia[$i]['02'] + $edad->v;     
                                            $TiempoHorasDelDia[$i]['02'] = $TiempoHorasDelDia[$i]['02'] + $edad->vd;     
                                            break;
                                        case 3:  
                                            $interaccionesHorasDelDia[$i]['03'] = $interaccionesHorasDelDia[$i]['03'] + $edad->v;     
                                            $TiempoHorasDelDia[$i]['03'] = $TiempoHorasDelDia[$i]['03'] + $edad->vd;     
                                            break;
                                        case 4:  
                                            $interaccionesHorasDelDia[$i]['04'] = $interaccionesHorasDelDia[$i]['04'] + $edad->v;     
                                            $TiempoHorasDelDia[$i]['04'] = $TiempoHorasDelDia[$i]['04'] + $edad->vd;     
                                            break;
                                        case 5:  
                                            $interaccionesHorasDelDia[$i]['05'] = $interaccionesHorasDelDia[$i]['05'] + $edad->v;     
                                            $TiempoHorasDelDia[$i]['05'] = $TiempoHorasDelDia[$i]['05'] + $edad->vd;     
                                            break;
                                        case 6:  
                                            $interaccionesHorasDelDia[$i]['06'] = $interaccionesHorasDelDia[$i]['06'] + $edad->v;     
                                            $TiempoHorasDelDia[$i]['06'] = $TiempoHorasDelDia[$i]['06'] + $edad->vd;     
                                            break;
                                        case 7:  
                                            $interaccionesHorasDelDia[$i]['07'] = $interaccionesHorasDelDia[$i]['07'] + $edad->v;     
                                            $TiempoHorasDelDia[$i]['07'] = $TiempoHorasDelDia[$i]['07'] + $edad->vd;     
                                            break;
                                        case 8:  
                                            $interaccionesHorasDelDia[$i]['08'] = $interaccionesHorasDelDia[$i]['08'] + $edad->v;     
                                            $TiempoHorasDelDia[$i]['08'] = $TiempoHorasDelDia[$i]['08'] + $edad->vd;     
                                            break;
                                        case 9:  
                                            $interaccionesHorasDelDia[$i]['09'] = $interaccionesHorasDelDia[$i]['09']+ $edad->v;     
                                            $TiempoHorasDelDia[$i]['09'] = $TiempoHorasDelDia[$i]['09'] + $edad->vd;     
                                            break;
                                        case 10:  
                                            $interaccionesHorasDelDia[$i]['10'] = $interaccionesHorasDelDia[$i]['10'] + $edad->v;     
                                            $TiempoHorasDelDia[$i]['10'] = $TiempoHorasDelDia[$i]['10'] + $edad->vd;     
                                            break;
                                        case 11:  
                                            $interaccionesHorasDelDia[$i]['11'] = $interaccionesHorasDelDia[$i]['11']+ $edad->v;     
                                            $TiempoHorasDelDia[$i]['11'] = $TiempoHorasDelDia[$i]['11'] + $edad->vd;     
                                            break;
                                        case 12:  
                                            $interaccionesHorasDelDia[$i]['12'] = $interaccionesHorasDelDia[$i]['12']+ $edad->v;     
                                            $TiempoHorasDelDia[$i]['12'] = $TiempoHorasDelDia[$i]['12'] + $edad->vd;     
                                            break;
                                        case 13:  
                                            $interaccionesHorasDelDia[$i]['13'] = $interaccionesHorasDelDia[$i]['13']+ $edad->v;     
                                            $TiempoHorasDelDia[$i]['13'] = $TiempoHorasDelDia[$i]['13'] + $edad->vd;     
                                            break;
                                        case 14:  
                                            $interaccionesHorasDelDia[$i]['14'] = $interaccionesHorasDelDia[$i]['14']+ $edad->v;     
                                            $TiempoHorasDelDia[$i]['14'] = $TiempoHorasDelDia[$i]['14'] + $edad->vd;     
                                            break;
                                        case 15:  
                                            $interaccionesHorasDelDia[$i]['15'] = $interaccionesHorasDelDia[$i]['15']+ $edad->v;     
                                            $TiempoHorasDelDia[$i]['15'] = $TiempoHorasDelDia[$i]['15'] + $edad->vd;     
                                            break;
                                        case 16:  
                                            $interaccionesHorasDelDia[$i]['16'] = $interaccionesHorasDelDia[$i]['16']+ $edad->v;     
                                            $TiempoHorasDelDia[$i]['16'] = $TiempoHorasDelDia[$i]['16'] + $edad->vd;     
                                            break;
                                        case 17:  
                                            $interaccionesHorasDelDia[$i]['17'] = $interaccionesHorasDelDia[$i]['17']+ $edad->v;     
                                            $TiempoHorasDelDia[$i]['17'] = $TiempoHorasDelDia[$i]['17'] + $edad->vd;     
                                            break;
                                        case 18:  
                                            $interaccionesHorasDelDia[$i]['18'] = $interaccionesHorasDelDia[$i]['18']+ $edad->v;     
                                            $TiempoHorasDelDia[$i]['18'] = $TiempoHorasDelDia[$i]['18'] + $edad->vd;     
                                            break;
                                        case 19:  
                                            $interaccionesHorasDelDia[$i]['19'] = $interaccionesHorasDelDia[$i]['19']+ $edad->v;     
                                            $TiempoHorasDelDia[$i]['19'] = $TiempoHorasDelDia[$i]['19'] + $edad->vd;     
                                            break;
                                        case 20:  
                                            $interaccionesHorasDelDia[$i]['20'] = $interaccionesHorasDelDia[$i]['20']+ $edad->v;     
                                            $TiempoHorasDelDia[$i]['20'] = $TiempoHorasDelDia[$i]['20'] + $edad->vd;     
                                            break;
                                        case 21:  
                                            $interaccionesHorasDelDia[$i]['21'] = $interaccionesHorasDelDia[$i]['21']+ $edad->v;     
                                            $TiempoHorasDelDia[$i]['21'] = $TiempoHorasDelDia[$i]['21'] + $edad->vd;     
                                            break;
                                        case 22:  
                                            $interaccionesHorasDelDia[$i]['22'] = $interaccionesHorasDelDia[$i]['22']+ $edad->v;     
                                            $TiempoHorasDelDia[$i]['22'] = $TiempoHorasDelDia[$i]['22'] + $edad->vd;     
                                            break;
                                        case 23:  
                                            $interaccionesHorasDelDia[$i]['23'] = $interaccionesHorasDelDia[$i]['23']+ $edad->v;     
                                            $TiempoHorasDelDia[$i]['23'] = $TiempoHorasDelDia[$i]['23'] + $edad->vd;     
                                            break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $this->genderAgeSplit($genderAgeSplit);
            $this->ImpactosPorSemana($ImpactosDiasDeLaSemana);
            $this->DuracionDeImpactosPorSemana($DuracionDiasDeLaSemana);

            $this->ImpactosPorHoraDelDia($interaccionesHorasDelDia);
            $this->DuracionDeImpactosPorHoraDelDia($TiempoHorasDelDia);
    }
    public function ImpactosPorSemana($ImpactosDiasDeLaSemana)
    {
        $grafica = Lava::DataTable();
            $grafica->addStringColumn('Day');
            $index = 0;
            foreach ($ImpactosDiasDeLaSemana as $row) {
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
                    array_push($arreglo, $ImpactosDiasDeLaSemana[$i][$weekMap[$indexWeekDay]]);   
                }
                $indexWeekDay++;
                $grafica->addRow($arreglo);
            }
            $grafica->setDateTimeFormat('l');
            Lava::ColumnChart('DemograficosImpactosPorSemana', $grafica, [
                // 'title' => 'Tiempos de interaccion durante los dias de la semana',
                'colors'=> ['#D4F4FF', '#85C1E5', '#337AB7', '#254E7B', '#FFEAF4','#E98195','#CF0029','#7B000B'],
                'titleTextStyle' => [
                    'color'    => '#eb6b2c',
                    'fontSize' => 14
                ],
                'vAxis' => [
                    'title'=>'Cantidad de impactos'
                ],
                'hAxis' => [
                    'title'=>'Impactos'
                ],
                'height' => 300,
                'width' => 650,
                'legend' => ['position'=> 'top', 'maxLines'=> 3],
                'isStacked' => 'true',
            ]);
    }
    public function ImpactosPorHoraDelDia($rows){
        // dd($rows);
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
        Lava::ColumnChart('ImpactosInteraccionesHorasAlDia', $grafica, [
            'colors'=> ['#D4F4FF', '#85C1E5', '#337AB7', '#254E7B', '#FFEAF4','#E98195','#CF0029','#7B000B'],
            'isStacked' => 'true',
            'vAxis' => [
                'title'=>'Cantidad de impactos'
            ],
            'hAxis' => [
                'title'=>'Impactos'
            ],
            'height' => 300,
            'width' => 650,
                'legend' => ['position'=> 'top', 'maxLines'=> 3],
        ]);
    }

    public function DuracionDeImpactosPorHoraDelDia($rows){
        // dd($rows);
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
        Lava::ColumnChart('DuracionImpactosInteraccionesHorasAlDia', $grafica, [
            'colors'=> ['#D4F4FF', '#85C1E5', '#337AB7', '#254E7B', '#FFEAF4','#E98195','#CF0029','#7B000B'],
            'isStacked' => 'true',
            'vAxis' => [
                'title'=>'Segundos de impacto'
            ],
            'hAxis' => [
                'title'=>'Impacto'
            ],
            'height' => 300,
            'width' => 650,
                'legend' => ['position'=> 'top', 'maxLines'=> 3],
        ]);
    }
    public function DuracionDeImpactosPorSemana($DuracionDeImpactosPorSemana)
    {
        $grafica = Lava::DataTable();
            $grafica->addStringColumn('Day');
            $index = 0;
            foreach ($DuracionDeImpactosPorSemana as $row) {
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
            // dd($DuracionDeImpactosPorSemana);
            $indexWeekDay= 0;
            foreach ($weekMap as $day) {
                $arreglo = [$day];    
                for ($i=0; $i < $index ; $i++) { 
                    array_push($arreglo, $DuracionDeImpactosPorSemana[$i][$weekMap[$indexWeekDay]]);   
                }
                $indexWeekDay++;
                $grafica->addRow($arreglo);
            }
            $grafica->setDateTimeFormat('l');
            Lava::ColumnChart('DuracionDemograficosImpactosPorSemana', $grafica, [
                'colors'=> ['#D4F4FF', '#85C1E5', '#337AB7', '#254E7B', '#FFEAF4','#E98195','#CF0029','#7B000B'],
                'titleTextStyle' => [
                    'color'    => '#eb6b2c',
                    'fontSize' => 14
                ],
                'vAxis' => [
                    'display'=>'Interacciones'
                ],
                'isStacked' => true,
                'height' => 300,
                'width' => 650,
                'legend' => 'top',
                'width' => 650,
                'legend' => ['position'=> 'top', 'maxLines'=> 3],
            ]);
            // dd($grafica);
    }

    public function genderAgeSplit($rows)
    {
        $grafica = Lava::DataTable();
            $grafica->addStringColumn('impactos');
            $index = 0;
        $arreglo =  array();
        foreach ($rows as $row) {
            array_push($arreglo, $row['cantidad']);
            $grafica->addNumberColumn($row['Nombre']);    
        }   
        $grafica->addRow(["Impactos",$arreglo[0],$arreglo[1],$arreglo[2],$arreglo[3],$arreglo[4],$arreglo[5],$arreglo[6],$arreglo[7]]);
        // dd($grafica);
        // $grafica->addRow([$row['Nombre'], $row['cantidad']]);
        // $arreglo = [];
        // for ($i=0; $i < count($rows) ; $i++) {         
        //     $arreglo = [$rows[$i]['Nombre']];
        //     array_push($arreglo, $rows[$i]['cantidad']);   
        //     $grafica->addRow($arreglo);
        // }
        
        // dd($grafica);
        $this->makeColumnChart('Comparacion de edades por género', $grafica, ['#D4F4FF','#85C1E5','#337AB7','#254E7B','#FFDFEE','#E98195','#CF0029','#7B000B'],'Edades por genero');
        
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
    public function HorasDelDia($rows,$nombreGrafica,$colores)
    {
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
                'display'=>'Interacciones'
            ],
            
            'height' => 300,
            'pieSliceText' => 'value',
            // 'is3D'   => true,
            'slices' => [
                
            ],
            // 'legend' => ['position'=> 'top', 'maxLines'=> 3],
        ]);
    }
    public function makePieChart($nombre, $grafica, $colores, $displayVaxis)
    {
        Lava::PieChart($nombre, $grafica, [
            // 'title' => 'Productos con mayor interacción',
            'colors'=> $colores,
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ],
            'vAxis' => [
                'display'=>'Interacciones'
            ],
            
            'height' => 300,
            // 'pieSliceText' => 'value',
            'is3D'   => false,
            'slices' => [
                ['offset' => 0.2],
                ['offset' => 0.25],
                ['offset' => 0.3]
            ],
            
            // 'legend' => ['position' => 'in'],
        ]);
    }

    public function makeDonutChart($nombre, $grafica, $colores, $displayVaxis)
    {
        Lava::DonutChart($nombre, $grafica, [
            // 'title' => 'Productos con mayor interacción',
            'colors'=> $colores,
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ],
            'vAxis' => [
                'display'=>'Interacciones'
            ],
            
            'height' => 300,
            // 'pieSliceText' => 'value',
            'is3D'   => false,
            'slices' => [
                ['offset' => 0.2],
                ['offset' => 0.25],
                ['offset' => 0.3]
            ],
            
            // 'legend' => ['position' => 'in'],
        ]);
    }
    
}