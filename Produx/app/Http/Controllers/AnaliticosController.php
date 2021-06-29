<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Lava;
use App\Models\User;
use App\Models\Accion;
use App\Models\Categoria;
use App\Models\Device;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Khill\Lavacharts\Laravel\LavachartsFacade;
use Khill\Lavacharts\Lavacharts;
use Symfony\Component\VarDumper\VarDumper;

class AnaliticosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tiempoInicial = 0, $tiempoFinal = 0, $categorias = 0)
    {   
        $tiempoEnMano = 0;
        $tiempoEnAnaquel = 0;
        $PrimerAccionGeneral = null;
        $UltimaAccionGeneral = null;
        $total = 0;
        $diff = 0;
        $contador = 0;
        $indexDiasDeSemana = 0;
        $productosTotales = 0;
        $productosConInteraccion = 0;
        $DispositivosDiasDeLaSemana = collect();
        $DispositivosHorasDelDia = collect();
        $MinutosDiasDeLaSemana = collect();
        $MinutosHorasDelDia = collect();
        $masLevantados = array( ['dispositivo' => null, 'cantidad' => 0], 
                                    ['dispositivo' => null, 'cantidad' => 0],
                                    ['dispositivo' => null, 'cantidad' => 0],
                                    ['dispositivo' => null, 'cantidad' => 0],
                                    ['dispositivo' => null, 'cantidad' => 0],
                                    );
        if($tiempoInicial == 0 && $tiempoFinal ==0){
            
        }
        if($categorias == 0){
            $currentTeamId = Auth::user()->current_team_id;
            $categoriasPorEquipo = Categoria::where('team_id','=',$currentTeamId)->get();
            $DispositivosTodos = collect();
            foreach ($categoriasPorEquipo as $categoria) {
                $devices = Device::where('categoria_id','=',$categoria->id)->get();
                $DispositivosTodos = $DispositivosTodos->merge($devices);
                
                $productosTotales = $productosTotales + $devices->count();
                foreach ($devices as $device) {
                    
                    $interaccionesDiasDeLaSemana = [
                        "Nombre" => $device->nombre,
                        "Dom"=>0,
                        "Lun"=>0,
                        "Mar"=>0,
                        "Mie"=>0,
                        "Jue"=>0,
                        "Vie"=>0,
                        "Sab"=>0
                    ];
                    $TiemposDiasDeLaSemana = [
                        "Nombre" => $device->nombre,
                        "Dom"=>["Mano"=>0, "Anaquel"=>0],
                        "Lun"=>["Mano"=>0, "Anaquel"=>0],
                        "Mar"=>["Mano"=>0, "Anaquel"=>0],
                        "Mie"=>["Mano"=>0, "Anaquel"=>0],
                        "Jue"=>["Mano"=>0, "Anaquel"=>0],
                        "Vie"=>["Mano"=>0, "Anaquel"=>0],
                        "Sab"=>["Mano"=>0, "Anaquel"=>0]
                    ];
                    $interaccionesHorasDelDia = [
                        "Nombre" => $device->nombre,
                        "00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,
                        "06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                        "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,
                        "18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0
                    ];
                    $TiempoHorasDelDia = [
                        "Nombre" => $device->nombre,
                        "00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,
                        "06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                        "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,
                        "18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0
                    ];
                    
                    $acciones = Accion::where('device_id','=',$device->id)->get();
                    if($acciones->count() > 0){
                        $productosConInteraccion++;
                    }
                    if($masLevantados[0]['dispositivo'] == null ){
                        $masLevantados[0]['cantidad'] = $acciones->count();
                        $masLevantados[0]['dispositivo'] = $device->nombre;
                    }elseif($masLevantados[1]['dispositivo'] == null ){
                        $masLevantados[1]['cantidad'] = $acciones->count();
                        $masLevantados[1]['dispositivo'] = $device->nombre;
                    }elseif($masLevantados[2]['dispositivo'] == null ){
                        $masLevantados[2]['cantidad'] = $acciones->count();
                        $masLevantados[2]['dispositivo'] = $device->nombre;
                    }elseif($masLevantados[3]['dispositivo'] == null ){
                        $masLevantados[3]['cantidad'] = $acciones->count();
                        $masLevantados[3]['dispositivo'] = $device->nombre;
                    }elseif($masLevantados[4]['dispositivo'] == null ){
                        $masLevantados[4]['cantidad'] = $acciones->count();
                        $masLevantados[4]['dispositivo'] = $device->nombre;
                    }elseif($acciones->count() > $masLevantados[0]['cantidad']){
                        $masLevantados[0]['cantidad'] = $acciones->count();
                        $masLevantados[0]['dispositivo'] = $device->nombre;
                    }elseif($acciones->count() > $masLevantados[1]['cantidad'] ){
                        $masLevantados[1]['cantidad'] = $acciones->count();
                        $masLevantados[1]['dispositivo'] = $device->nombre;
                    }elseif($acciones->count() > $masLevantados[2]['cantidad'] ){
                        $masLevantados[2]['cantidad'] = $acciones->count();
                        $masLevantados[2]['dispositivo'] = $device->nombre;
                    }elseif($acciones->count() > $masLevantados[3]['cantidad'] ){
                        $masLevantados[3]['cantidad'] = $acciones->count();
                        $masLevantados[3]['dispositivo'] = $device->nombre;
                    }elseif($acciones->count() > $masLevantados[4]['cantidad'] ){
                        $masLevantados[4]['cantidad'] = $acciones->count();
                        $masLevantados[4]['dispositivo'] = $device->nombre;
                    }
                    foreach ($acciones as $accion) {
                        if ($accion->tipo == 1) {
                            $tiempoInicial = $accion->created_at;
                            $dayOfTheWeek = $tiempoInicial->dayOfWeek;
                            switch ($dayOfTheWeek) {
                                case 0:
                                    $interaccionesDiasDeLaSemana['Dom']++;
                                    break;
                                case 1:
                                    $interaccionesDiasDeLaSemana['Lun']++;
                                    break;
                                case 2:
                                    $interaccionesDiasDeLaSemana['Mar']++;
                                    break;
                                case 3:
                                    $interaccionesDiasDeLaSemana['Mie']++;
                                    break;
                                case 4:
                                    $interaccionesDiasDeLaSemana['Jue']++;
                                    break;
                                case 5:
                                    $interaccionesDiasDeLaSemana['Vie']++;
                                    break;
                                case 6:
                                    $interaccionesDiasDeLaSemana['Sab']++;
                                    break;                                
                                default:
                                $interaccionesDiasDeLaSemana['Dom']++;
                                    break;
                            }
                            $hourOfTheDay = ($tiempoInicial->hour);
                            switch ($hourOfTheDay) {
                                case 0: $interaccionesHorasDelDia['00']++;     break;
                                case 1: $interaccionesHorasDelDia['01']++;  break;
                                case 2: $interaccionesHorasDelDia['02']++;  break;
                                case 3: $interaccionesHorasDelDia['03']++;  break;
                                case 4: $interaccionesHorasDelDia['04']++;  break;
                                case 5: $interaccionesHorasDelDia['05']++;  break;
                                case 6: $interaccionesHorasDelDia['06']++;  break;                                
                                case 7: $interaccionesHorasDelDia['07']++;  break;
                                case 8: $interaccionesHorasDelDia['08']++;  break;
                                case 9: $interaccionesHorasDelDia['09']++;  break;
                                case 10: $interaccionesHorasDelDia['10']++;  break;
                                case 11: $interaccionesHorasDelDia['11']++;  break;
                                case 12: $interaccionesHorasDelDia['12']++;  break;
                                case 13: $interaccionesHorasDelDia['13']++;  break;
                                case 14: $interaccionesHorasDelDia['14']++;  break;
                                case 15: $interaccionesHorasDelDia['15']++;  break;
                                case 16: $interaccionesHorasDelDia['16']++;  break;
                                case 17: $interaccionesHorasDelDia['17']++;  break;
                                case 18: $interaccionesHorasDelDia['18']++;  break;
                                case 19: $interaccionesHorasDelDia['19']++;  break;
                                case 20: $interaccionesHorasDelDia['20']++;  break;
                                case 21: $interaccionesHorasDelDia['21']++;  break;
                                case 22: $interaccionesHorasDelDia['22']++;  break;
                                case 23: $interaccionesHorasDelDia['23']++;  break;   
                            }
                            
                            $contador++;
                        } else if ($accion->tipo == 0) {
                            $tiempoFinal = $accion->created_at;
                            if ($tiempoInicial) {
                                $diferencia = $tiempoInicial->diffInMinutes($tiempoFinal);
                                $diferenciaSegundos = $tiempoInicial->diffInSeconds($tiempoFinal);
                                $diff = $diff +  $diferenciaSegundos;
                                $dayOfTheWeek = $tiempoInicial->dayOfWeek;
                                $hourOfTheDay = $tiempoInicial->hour;
                                // echo $diff."-\-\-".$tiempoInicial->diffInSeconds($tiempoFinal)."///// ".$tiempoInicial."---".$tiempoFinal."<br>";
                                
                            switch ($dayOfTheWeek) {
                                case 0:
                                    
                                    $TiemposDiasDeLaSemana['Dom']['Mano'] =$TiemposDiasDeLaSemana['Dom']['Mano'] + $diferenciaSegundos ;
                                    break;
                                case 1:
                                    $TiemposDiasDeLaSemana['Lun']['Mano'] =$TiemposDiasDeLaSemana['Lun']['Mano'] + $diferenciaSegundos ;
                                    break;
                                case 2:
                                    $TiemposDiasDeLaSemana['Mar']['Mano'] =$TiemposDiasDeLaSemana['Mar']['Mano'] + $diferenciaSegundos ;
                                    break;
                                case 3:
                                    
                                    $TiemposDiasDeLaSemana['Mie']['Mano'] =$TiemposDiasDeLaSemana['Mie']['Mano'] + $diferenciaSegundos ;
                                    break;
                                case 4:
                                    $TiemposDiasDeLaSemana['Jue']['Mano'] =$TiemposDiasDeLaSemana['Jue']['Mano'] + $diferenciaSegundos ;
                                    break;
                                case 5:
                                    $TiemposDiasDeLaSemana['Vie']['Mano'] =$TiemposDiasDeLaSemana['Vie']['Mano'] + $diferenciaSegundos ;
                                    break;
                                case 6:
                                    $TiemposDiasDeLaSemana['Sab']['Mano'] =$TiemposDiasDeLaSemana['Sab']['Mano'] + $diferenciaSegundos ;
                                    break;                                
                                default:
                                $TiemposDiasDeLaSemana['Dom']['Mano']++;
                                    break;
                            }
                            $hourOfTheDay = strval($hourOfTheDay);
                            switch ($hourOfTheDay) {
                                case ('00'):
                                    $TiempoHorasDelDia['00'] =$TiempoHorasDelDia['00'] + $diferenciaSegundos ;
                                    break;
                                case ('01'):
                                    $TiempoHorasDelDia['01'] =$TiempoHorasDelDia['01'] + $diferenciaSegundos ;
                                    break;
                                case '02':
                                    $TiempoHorasDelDia['02'] =$TiempoHorasDelDia['02'] + $diferenciaSegundos ;
                                    break;
                                case '03':
                                    $TiempoHorasDelDia['03'] =$TiempoHorasDelDia['03'] + $diferenciaSegundos ;
                                    break;
                                case '04':
                                    $TiempoHorasDelDia['04'] =$TiempoHorasDelDia['04'] + $diferenciaSegundos ;
                                    break;
                                case '05':
                                    $TiempoHorasDelDia['05'] =$TiempoHorasDelDia['05'] + $diferenciaSegundos ;
                                    break;
                                case ('06'):
                                    $TiempoHorasDelDia['06'] =$TiempoHorasDelDia['06'] + $diferenciaSegundos ;
                                    break;
                                case ('07'):
                                    $TiempoHorasDelDia['07'] =$TiempoHorasDelDia['07'] + $diferenciaSegundos ;
                                    break;
                                case '08':
                                    $TiempoHorasDelDia['08'] =$TiempoHorasDelDia['08'] + $diferenciaSegundos ;
                                    break;
                                case '09':
                                    $TiempoHorasDelDia['09'] =$TiempoHorasDelDia['09'] + $diferenciaSegundos ;
                                    break;
                                case '10':
                                    $TiempoHorasDelDia['10'] =$TiempoHorasDelDia['10'] + $diferenciaSegundos ;
                                    break;
                                case '11':
                                    $TiempoHorasDelDia['11'] =$TiempoHorasDelDia['11'] + $diferenciaSegundos ;
                                    break;
                                case '12':
                                    $TiempoHorasDelDia['12'] =$TiempoHorasDelDia['12'] + $diferenciaSegundos ;
                                    break;
                                case ('13'):
                                    $TiempoHorasDelDia['13'] =$TiempoHorasDelDia['13'] + $diferenciaSegundos ;
                                    break;
                                case ('14'):
                                    $TiempoHorasDelDia['14'] =$TiempoHorasDelDia['14'] + $diferenciaSegundos ;
                                    break;
                                case ("15"):
                                    $TiempoHorasDelDia['15'] =$TiempoHorasDelDia['15'] + $diferenciaSegundos ;
                                    break;
                                case '16'|| '16':
                                    $TiempoHorasDelDia['16'] =$TiempoHorasDelDia['16'] + $diferenciaSegundos ;
                                    break;
                                case '17' || '17':
                                    $TiempoHorasDelDia['17'] =$TiempoHorasDelDia['17'] + $diferenciaSegundos ;
                                    break;
                                case '18' || '18':
                                    $TiempoHorasDelDia['18'] =$TiempoHorasDelDia['18'] + $diferenciaSegundos ;
                                    break;
                                case ('19'||'19'):
                                    $TiempoHorasDelDia['19'] =$TiempoHorasDelDia['19'] + $diferenciaSegundos ;
                                    break;
                                case ('20'|| '20'):
                                    $TiempoHorasDelDia['20'] =$TiempoHorasDelDia['20'] + $diferenciaSegundos ;
                                    break;
                                case '21'||'21':
                                    $TiempoHorasDelDia['21'] =$TiempoHorasDelDia['21'] + $diferenciaSegundos ;
                                    break;
                                case '22'|| '22':
                                    $TiempoHorasDelDia['22'] =$TiempoHorasDelDia['22'] + $diferenciaSegundos ;
                                    break;
                                case '23' || '23':
                                    $TiempoHorasDelDia['23'] =$TiempoHorasDelDia['23'] + $diferenciaSegundos ;
                                    break;
                                case '24' || '24':
                                    $TiempoHorasDelDia['24'] =$TiempoHorasDelDia['24'] + $diferenciaSegundos ;
                                    break;
                                default:
                                $TiempoHorasDelDia['00'] =$TiempoHorasDelDia['00'] + $diferenciaSegundos ;
                                    break;
                            }

                            }
                            $tiempoFinal = $tiempoInicial = null;
                        }           
                        
                    }

                    
                    
                    for ($mes=01; $mes <12 ; $mes++) { 
                        for ($dia=01; $dia <31 ; $dia++) { 
                            $fechaBase = Carbon::parse("2021-".$mes."-".$dia)->toDateString();
                            $from = $fechaBase."T00:00:00.00";
                            $to   = $fechaBase."T23:59:59.999";
                            $PrimerAccionEnDia = Accion::where('device_id','=',$device->id)->whereBetween('created_at', [$from, $to])->orderBy('created_at','ASC')
                            ->first(); 
                            if($PrimerAccionGeneral == null){
                                if($PrimerAccionEnDia != null){
                                    $UltimaAccionEnDia = Accion::where('device_id','=',$device->id)->whereBetween('created_at', [$from, $to])
                                                ->orderBy('created_at','DESC')
                                                ->first();
                                    if(
                                        $PrimerAccionEnDia !=""
                                        ){      
                                            $diferencia = ($PrimerAccionEnDia->created_at->diffInSeconds($UltimaAccionEnDia->created_at));
                                            $total = $total + $diferencia;
                                            
                                    }else{
                                        $total = $total + 0;
                                    }
                                }
                            }
                                            
                                   
                        }
                    }
                    
                    
                    
                    $MinutosDiasDeLaSemana[$indexDiasDeSemana] = $TiemposDiasDeLaSemana;
                    $DispositivosDiasDeLaSemana[$indexDiasDeSemana] = $interaccionesDiasDeLaSemana;
                    $DispositivosHorasDelDia[$indexDiasDeSemana] = $interaccionesHorasDelDia;
                    $MinutosHorasDelDia[$indexDiasDeSemana] = $TiempoHorasDelDia;
                    $indexDiasDeSemana++;
                    
                }
                
                    
            }
            
        }else{
            
            
        }
        // dd($total);
        $fechaInicial=Accion::where('device_id','=',$device->id)->orderBy('created_at','ASC')->first();
        $fechaInicial = $fechaInicial->created_at;
        $fechaFinal=Accion::where('device_id','=',$device->id)->orderBy('created_at','DESC')->first();
        $fechaFinal = $fechaFinal->created_at;
        $infos = collect();
        $infos->fechaInicial = $fechaInicial->addDay(1)->format("Y-m-d");
        $infos->fechaFinal = $fechaFinal->addDay(2)->format("Y-m-d");
        $infos->productosTotales =  (int)(($productosTotales));
        $rows = collect([
            ['Minutos en mano', $diff],
            ['Minutos en anaquel', $total],
        ]);
        $infos->productosConInteraccion =  (int)(($productosConInteraccion));
        $infos->porcentajeInteracciones =  (int)(($productosConInteraccion*100)/ $productosTotales);
        if($infos->productosConInteraccion == 0){
            $infos->tiempoEnAnaquel = 0;    
            $infos->tiempoEnMano = 0;
        }else {
        $infos->tiempoEnAnaquel =  (int)(($rows[1][1])/$infos->productosTotales);
        $infos->tiempoEnMano =  (int)(($rows[0][1])/$infos->productosConInteraccion);
        $infos->tiempoEnAnaquel = ($infos->tiempoEnAnaquel)-($infos->tiempoEnMano);
        }
        if($infos->tiempoEnAnaquel != 0 ){
            $infos->porcentajeDeTiempo =  (int)(($infos->tiempoEnMano*100)/ $infos->tiempoEnAnaquel);
        }else{
            $infos->porcentajeDeTiempo =  0;
        }
        if((($infos->tiempoEnAnaquel)-($infos->tiempoEnMano))> 0 ){
            $rows = collect([
                ['Minutos en mano', $infos->tiempoEnMano],
                ['Minutos en anaquel', ($infos->tiempoEnAnaquel)],
            ]);
        }else {
            $rows = collect([
                ['Minutos en mano', $infos->tiempoEnMano],
                ['Minutos en anaquel', 0],
            ]);
        }
        
        // dd($infos);
        
        $this->TopProductosGrafica($masLevantados);
        $this->DiasDeLaSemanaGrafica($DispositivosDiasDeLaSemana);
        $this->HorasGrafica($DispositivosHorasDelDia);
        $this->TiempoMano_TiempoAnaquel($rows);
        $this->TiempoManoSemanaGrafica($MinutosDiasDeLaSemana);
        $this->TiempoManoHorasGrafica($MinutosHorasDelDia);
        $fechaActual = (Carbon::now());

        // Api SEEMETRIX
        // dd($categoria);
        $idUserSeemetrix = $categoria->api_user_id;
        $keyUserSeemetrix = $categoria->api_key_id;
        $DevicesIds = new Collection();
        $DevicesIds->push($categoria->api_device_id);
        $seemetrix = app('App\Http\Controllers\SeemetrixController')->getDataFromSeemetrix($idUserSeemetrix,$keyUserSeemetrix, $DevicesIds, $infos->fechaInicial, $infos->fechaFinal);
        
        // dd($seemetrix);

        return view ('analiticos',compact('infos', 'categoriasPorEquipo','DispositivosTodos', 'fechaActual', 'seemetrix'));
    }


    public function TiempoManoSemanaGrafica($rows){
        $grafica = Lava::DataTable();
        $grafica->addStringColumn('Day');
        $index = 0;
        foreach ($rows as $row) {
            $index++;
            $grafica->addNumberColumn($row['Nombre']);
        }
        // dd($rows);
        $weekMap = [
            0 => 'Dom',
            1 => 'Lun',
            2 => 'Mar',
            3 => 'Mie',
            4 => 'Jue',
            5 => 'Vie',
            6 => 'Sab',
        ];
        $indexWeekDay= 0;
        foreach ($weekMap as $day) {
            $arreglo = [$day];    
            for ($i=0; $i < $index ; $i++) { 
                array_push($arreglo, (($rows[$i][$weekMap[$indexWeekDay]]["Mano"])/60) );   
            }
            
            $indexWeekDay++;
            $grafica->addRow($arreglo);
        }
        $grafica->setDateTimeFormat('l');
        Lava::ColumnChart('TiemposDiasDeLaSemana', $grafica, [
            // 'title' => 'Tiempos de interaccion durante los dias de la semana',
            'colors'=> ['#123EAB', '#009999', '#FF7400', '#FFAB00', '#744E00'],
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ],
            'vAxis' => [
                'title'=>'Minutos de interacción'
            ],
            'hAxis' => [
                'title'=>'Productos'
            ],
            'height' => 300,
            
            'is3D'   => true,
            'slices' => [
                
            ],
            'legend' => ['position'=> 'top', 'maxLines'=> 3],
            // 'isStacked' => 'true',
        ]);
    }
    
    public function TiempoMano_TiempoAnaquel($rows){
        $grafica = Lava::DataTable();
        $grafica->addStringColumn('Interaccion')
                                ->addNumberColumn('Tiempo');
                                foreach ($rows as $row) {
                                    $grafica->addRow([$row[0]  ,($row[1]/60)]);
                                }
        Lava::PieChart('levantamientosVSReposo', $grafica, [
                        'colors'=> ['#2d6b22', '#8ab446', '#ec8f6e', '#f3b49f', '#f6c7b6'],
                        // 'title' => 'Tiempo en mano - Tiempo en anaquel',
                        // 'legend' => 'in',
                        'vAxis' => [
                            'title'=>'Minutos'
                        ],
                        'hAxis' => [
                            'title'=>'Minutos'
                        ],
                        'height' => 300,
                        'pieSliceText' => 'value',
                        'is3D'   => true,
                        'slices' => [
                            
                        ],
                        'legend' => ['position'=> 'top', 'maxLines'=> 3],
                        // ['offset' => 0.2],
                        // ['offset' => 0.25],
                        // ['offset' => 0.3]
                        
                    ]);
    }
    public function TopProductosGrafica($rows){
        unset($rows[count($rows)-1]);
        
        $grafica = Lava::DataTable();
            $grafica->addStringColumn('Interacciones');
            $grafica->setDateTimeFormat('l');
            $index = 0;
        foreach ($rows as $row) {
            $grafica->addNumberColumn($row['dispositivo']);
            $index++;
        }
        $arreglo = ["Productos"];    
                for ($i=0; $i < $index ; $i++) { 
                    array_push($arreglo, $rows[$i]['cantidad']);   
                }
                $grafica->addRow($arreglo);
            // dd($grafica);
        Lava::ColumnChart('TopMasInteracciones', $grafica, [
            // 'title' => 'Productos con mayor interacción',
            'colors'=> ['#01B8AA', '#374649', '#FD625E', '#F2C80F', '#5F6B6D'],
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ],
            'vAxis' => [
                'display'=>'Interacciones'
            ],
            
            'height' => 300,
            'pieSliceText' => 'value',
            'is3D'   => true,
            'slices' => [
                
            ],
            'legend' => ['position'=> 'top', 'maxLines'=> 3],
        ]);
    }
    public function DiasDeLaSemanaGrafica($rows){
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
            $grafica->setDateTimeFormat('l');
// dd($grafica);
        
        Lava::ColumnChart('ProductosInteraccionesDiasDeLaSemana', $grafica, [
            // 'title' => 'Interacciones durante los dias de la semana',
            'colors'=> ['#01B8AA', '#374649', '#FD625E', '#F2C80F', '#5F6B6D'],
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ],
            'vAxis' => [
                'title'=>'Interacciones'
            ],
            'hAxis' => [
                'title'=>'Productos'
            ],
            'height' => 300,
            
            'pieSliceText' => 'value',
            'is3D'   => true,
            'slices' => [
                
            ],
            'legend' => ['position'=> 'top', 'maxLines'=> 3],
            'isStacked' => 'true',
        ]);
    }

    public function HorasGrafica($rows){
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
        Lava::ColumnChart('ProductosInteraccionesHorasAlDia', $grafica, [
            'colors'=> ['#01B8AA', '#374649', '#FD625E', '#F2C80F', '#5F6B6D'],
            'isStacked' => 'true',
            'vAxis' => [
                'title'=>'Interacciones'
            ],
            'hAxis' => [
                'title'=>'Productos'
            ],
            'height' => 300,
            
            'pieSliceText' => 'value',
            'is3D'   => true,
            'slices' => [
                
            ],
            'legend' => ['position'=> 'top', 'maxLines'=> 3],
        ]);
    }
    public function TiempoManoHorasGrafica($rows){
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
                    array_push($arreglo, $rows[$i][$DaysMap[$indexWeekDay]]/60);   
                }
                $indexWeekDay++;
                $grafica->addRow($arreglo);
            }
            // $legendStyle = Lava::textStyle()->color('#F3BB00')->fontName('Arial')->fontSize(20);

        Lava::ColumnChart('TiemposInteraccionesHorasAlDia', $grafica, [
            'colors'=> ['#123EAB', '#009999', '#FF7400', '#FFAB00', '#744E00'],
            'isStacked' => 'true',
            'vAxis' => [
                'title'=>'Minutos'
            ],
            'hAxis' => [
                'title'=>'Productos'
            ],
            'height' => 300,
            
            'pieSliceText' => 'value',
            'is3D'   => true,
            'slices' => [
                
            ],
            // 'legend' => 'bottom',
            'legend' => ['position'=> 'top', 'maxLines'=> 3],

            // position('bottom')->alignment('start')->textStyle($legendStyle);
        ]);
    }
    public function filtrarAnaliticos(Request $request)
    {

        $categorias = $request->values;
        // dd($categorias);
        if($categorias == null){
            $currentTeamId = Auth::user()->current_team_id;
            $categoriasPorEquipo = Categoria::where('team_id','=',$currentTeamId)->get();
        }else{
            $categorias = explode (",", $categorias); 
            $categoriasPorEquipo = Categoria::whereIn('id',$categorias)->get();
        }
        $fechaInicial = $request->fechaInicial;
        $fechaFinal = $request->fechaFinal;
        $fechaInicialAuxiliar = $fechaInicial;
        $fechaFinalAuxiliar = $fechaFinal;
        // $this->index($fechaInicial, $fechaFinal, $categorias)
        
        $tiempoEnMano = 0;
        $tiempoEnAnaquel = 0;
        $PrimerAccionGeneral = null;
        $UltimaAccionGeneral = null;
        $total = 0;
        $diff = 0;
        $contador = 0;
        $indexDiasDeSemana = 0;
        $productosTotales = 0;
        $productosConInteraccion = 0;
        $DispositivosDiasDeLaSemana = collect();
        $DispositivosHorasDelDia = collect();
        $MinutosDiasDeLaSemana = collect();
        $MinutosHorasDelDia = collect();
        $masLevantados = array( ['dispositivo' => null, 'cantidad' => 0], 
                                    ['dispositivo' => null, 'cantidad' => 0],
                                    ['dispositivo' => null, 'cantidad' => 0],
                                    ['dispositivo' => null, 'cantidad' => 0],
                                    ['dispositivo' => null, 'cantidad' => 0],
                                    );
        
            $currentTeamId = Auth::user()->current_team_id;
            
            $DispositivosTodos = collect();
            
            foreach ($categoriasPorEquipo as $categoria) {
                $devices = Device::where('categoria_id','=',$categoria->id)->get();
                $DispositivosTodos = $DispositivosTodos->merge($devices);
                
                $productosTotales = $productosTotales + $devices->count();
                
                foreach ($devices as $device) {
                    
                    $interaccionesDiasDeLaSemana = [
                        "Nombre" => $device->nombre,
                        "Dom"=>0,
                        "Lun"=>0,
                        "Mar"=>0,
                        "Mie"=>0,
                        "Jue"=>0,
                        "Vie"=>0,
                        "Sab"=>0
                    ];
                    $TiemposDiasDeLaSemana = [
                        "Nombre" => $device->nombre,
                        "Dom"=>["Mano"=>0, "Anaquel"=>0],
                        "Lun"=>["Mano"=>0, "Anaquel"=>0],
                        "Mar"=>["Mano"=>0, "Anaquel"=>0],
                        "Mie"=>["Mano"=>0, "Anaquel"=>0],
                        "Jue"=>["Mano"=>0, "Anaquel"=>0],
                        "Vie"=>["Mano"=>0, "Anaquel"=>0],
                        "Sab"=>["Mano"=>0, "Anaquel"=>0]
                    ];
                    $interaccionesHorasDelDia = [
                        "Nombre" => $device->nombre,
                        "00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,
                        "06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                        "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,
                        "18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0
                    ];
                    $TiempoHorasDelDia = [
                        "Nombre" => $device->nombre,
                        "00"=>0,"01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,
                        "06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,
                        "12"=>0,"13"=>0,"14"=>0,"15"=>0,"16"=>0,"17"=>0,
                        "18"=>0,"19"=>0,"20"=>0,"21"=>0,"22"=>0,"23"=>0
                    ];
                    if($fechaInicial == $fechaFinal){
                        $acciones = Accion::where('device_id','=',$device->id)->get();
                        
                    }else{
                        
                        $acciones = Accion::where('device_id','=',$device->id)->whereBetween('created_at', [Carbon::parse($fechaInicial), Carbon::parse($fechaFinal)])->get();
                    }
                    
                    
                    if($acciones->count() > 0){
                        $productosConInteraccion++;
                    }
                    if($masLevantados[0]['dispositivo'] == null ){
                        $masLevantados[0]['cantidad'] = $acciones->count();
                        $masLevantados[0]['dispositivo'] = $device->nombre;
                    }elseif($masLevantados[1]['dispositivo'] == null ){
                        $masLevantados[1]['cantidad'] = $acciones->count();
                        $masLevantados[1]['dispositivo'] = $device->nombre;
                    }elseif($masLevantados[2]['dispositivo'] == null ){
                        $masLevantados[2]['cantidad'] = $acciones->count();
                        $masLevantados[2]['dispositivo'] = $device->nombre;
                    }elseif($masLevantados[3]['dispositivo'] == null ){
                        $masLevantados[3]['cantidad'] = $acciones->count();
                        $masLevantados[3]['dispositivo'] = $device->nombre;
                    }elseif($masLevantados[4]['dispositivo'] == null ){
                        $masLevantados[4]['cantidad'] = $acciones->count();
                        $masLevantados[4]['dispositivo'] = $device->nombre;
                    }elseif($acciones->count() > $masLevantados[0]['cantidad']){
                        $masLevantados[0]['cantidad'] = $acciones->count();
                        $masLevantados[0]['dispositivo'] = $device->nombre;
                    }elseif($acciones->count() > $masLevantados[1]['cantidad'] ){
                        $masLevantados[1]['cantidad'] = $acciones->count();
                        $masLevantados[1]['dispositivo'] = $device->nombre;
                    }elseif($acciones->count() > $masLevantados[2]['cantidad'] ){
                        $masLevantados[2]['cantidad'] = $acciones->count();
                        $masLevantados[2]['dispositivo'] = $device->nombre;
                    }elseif($acciones->count() > $masLevantados[3]['cantidad'] ){
                        $masLevantados[3]['cantidad'] = $acciones->count();
                        $masLevantados[3]['dispositivo'] = $device->nombre;
                    }elseif($acciones->count() > $masLevantados[4]['cantidad'] ){
                        $masLevantados[4]['cantidad'] = $acciones->count();
                        $masLevantados[4]['dispositivo'] = $device->nombre;
                    }
                    foreach ($acciones as $accion) {
                        // dd($acciones);
                        if ($accion->tipo == 1) {
                            $tiempoInicial = $accion->created_at;
                            $dayOfTheWeek = $tiempoInicial->dayOfWeek;
                            switch ($dayOfTheWeek) {
                                case 0:
                                    $interaccionesDiasDeLaSemana['Dom']++;
                                    break;
                                case 1:
                                    $interaccionesDiasDeLaSemana['Lun']++;
                                    break;
                                case 2:
                                    $interaccionesDiasDeLaSemana['Mar']++;
                                    break;
                                case 3:
                                    $interaccionesDiasDeLaSemana['Mie']++;
                                    break;
                                case 4:
                                    $interaccionesDiasDeLaSemana['Jue']++;
                                    break;
                                case 5:
                                    $interaccionesDiasDeLaSemana['Vie']++;
                                    break;
                                case 6:
                                    $interaccionesDiasDeLaSemana['Sab']++;
                                    break;                                
                                default:
                                $interaccionesDiasDeLaSemana['Dom']++;
                                    break;
                            }
                            $hourOfTheDay = ($tiempoInicial->hour);
                            switch ($hourOfTheDay) {
                                case 0: $interaccionesHorasDelDia['00']++;     break;
                                case 1: $interaccionesHorasDelDia['01']++;  break;
                                case 2: $interaccionesHorasDelDia['02']++;  break;
                                case 3: $interaccionesHorasDelDia['03']++;  break;
                                case 4: $interaccionesHorasDelDia['04']++;  break;
                                case 5: $interaccionesHorasDelDia['05']++;  break;
                                case 6: $interaccionesHorasDelDia['06']++;  break;                                
                                case 7: $interaccionesHorasDelDia['07']++;  break;
                                case 8: $interaccionesHorasDelDia['08']++;  break;
                                case 9: $interaccionesHorasDelDia['09']++;  break;
                                case 10: $interaccionesHorasDelDia['10']++;  break;
                                case 11: $interaccionesHorasDelDia['11']++;  break;
                                case 12: $interaccionesHorasDelDia['12']++;  break;
                                case 13: $interaccionesHorasDelDia['13']++;  break;
                                case 14: $interaccionesHorasDelDia['14']++;  break;
                                case 15: $interaccionesHorasDelDia['15']++;  break;
                                case 16: $interaccionesHorasDelDia['16']++;  break;
                                case 17: $interaccionesHorasDelDia['17']++;  break;
                                case 18: $interaccionesHorasDelDia['18']++;  break;
                                case 19: $interaccionesHorasDelDia['19']++;  break;
                                case 20: $interaccionesHorasDelDia['20']++;  break;
                                case 21: $interaccionesHorasDelDia['21']++;  break;
                                case 22: $interaccionesHorasDelDia['22']++;  break;
                                case 23: $interaccionesHorasDelDia['23']++;  break;   
                            }
                            
                            $contador++;
                        } else if ($accion->tipo == 0) {
                            $tiempoFinal = $accion->created_at;
                            if (isset($tiempoInicial)) {
                                
                                    
                                $diferencia = $tiempoInicial->diffInMinutes($tiempoFinal);
                                $diferenciaSegundos = $tiempoInicial->diffInSeconds($tiempoFinal);
                                
                                
                                $diff = $diff +  $diferenciaSegundos;
                                
                                $dayOfTheWeek = $tiempoInicial->dayOfWeek;
                                $hourOfTheDay = $tiempoInicial->hour;
                                // echo $diff."-\-\-".$tiempoInicial->diffInSeconds($tiempoFinal)."///// ".$tiempoInicial."---".$tiempoFinal."<br>";
                                
                            switch ($dayOfTheWeek) {
                                case 0:
                                    
                                    $TiemposDiasDeLaSemana['Dom']['Mano'] =$TiemposDiasDeLaSemana['Dom']['Mano'] + $diferenciaSegundos ;
                                    break;
                                case 1:
                                    $TiemposDiasDeLaSemana['Lun']['Mano'] =$TiemposDiasDeLaSemana['Lun']['Mano'] + $diferenciaSegundos ;
                                    break;
                                case 2:
                                    $TiemposDiasDeLaSemana['Mar']['Mano'] =$TiemposDiasDeLaSemana['Mar']['Mano'] + $diferenciaSegundos ;
                                    break;
                                case 3:
                                    
                                    $TiemposDiasDeLaSemana['Mie']['Mano'] =$TiemposDiasDeLaSemana['Mie']['Mano'] + $diferenciaSegundos ;
                                    break;
                                case 4:
                                    $TiemposDiasDeLaSemana['Jue']['Mano'] =$TiemposDiasDeLaSemana['Jue']['Mano'] + $diferenciaSegundos ;
                                    break;
                                case 5:
                                    $TiemposDiasDeLaSemana['Vie']['Mano'] =$TiemposDiasDeLaSemana['Vie']['Mano'] + $diferenciaSegundos ;
                                    break;
                                case 6:
                                    $TiemposDiasDeLaSemana['Sab']['Mano'] =$TiemposDiasDeLaSemana['Sab']['Mano'] + $diferenciaSegundos ;
                                    break;                                
                                default:
                                $TiemposDiasDeLaSemana['Dom']['Mano']++;
                                    break;
                            }
                            $hourOfTheDay = strval($hourOfTheDay);
                            switch ($hourOfTheDay) {
                                case ('00'):
                                    $TiempoHorasDelDia['00'] =$TiempoHorasDelDia['00'] + $diferenciaSegundos ;
                                    break;
                                case ('01'):
                                    $TiempoHorasDelDia['01'] =$TiempoHorasDelDia['01'] + $diferenciaSegundos ;
                                    break;
                                case '02':
                                    $TiempoHorasDelDia['02'] =$TiempoHorasDelDia['02'] + $diferenciaSegundos ;
                                    break;
                                case '03':
                                    $TiempoHorasDelDia['03'] =$TiempoHorasDelDia['03'] + $diferenciaSegundos ;
                                    break;
                                case '04':
                                    $TiempoHorasDelDia['04'] =$TiempoHorasDelDia['04'] + $diferenciaSegundos ;
                                    break;
                                case '05':
                                    $TiempoHorasDelDia['05'] =$TiempoHorasDelDia['05'] + $diferenciaSegundos ;
                                    break;
                                case ('06'):
                                    $TiempoHorasDelDia['06'] =$TiempoHorasDelDia['06'] + $diferenciaSegundos ;
                                    break;
                                case ('07'):
                                    $TiempoHorasDelDia['07'] =$TiempoHorasDelDia['07'] + $diferenciaSegundos ;
                                    break;
                                case '08':
                                    $TiempoHorasDelDia['08'] =$TiempoHorasDelDia['08'] + $diferenciaSegundos ;
                                    break;
                                case '09':
                                    $TiempoHorasDelDia['09'] =$TiempoHorasDelDia['09'] + $diferenciaSegundos ;
                                    break;
                                case '10':
                                    $TiempoHorasDelDia['10'] =$TiempoHorasDelDia['10'] + $diferenciaSegundos ;
                                    break;
                                case '11':
                                    $TiempoHorasDelDia['11'] =$TiempoHorasDelDia['11'] + $diferenciaSegundos ;
                                    break;
                                case '12':
                                    $TiempoHorasDelDia['12'] =$TiempoHorasDelDia['12'] + $diferenciaSegundos ;
                                    break;
                                case ('13'):
                                    $TiempoHorasDelDia['13'] =$TiempoHorasDelDia['13'] + $diferenciaSegundos ;
                                    break;
                                case ('14'):
                                    $TiempoHorasDelDia['14'] =$TiempoHorasDelDia['14'] + $diferenciaSegundos ;
                                    break;
                                case ("15"):
                                    $TiempoHorasDelDia['15'] =$TiempoHorasDelDia['15'] + $diferenciaSegundos ;
                                    break;
                                case '16'|| '16':
                                    $TiempoHorasDelDia['16'] =$TiempoHorasDelDia['16'] + $diferenciaSegundos ;
                                    break;
                                case '17' || '17':
                                    $TiempoHorasDelDia['17'] =$TiempoHorasDelDia['17'] + $diferenciaSegundos ;
                                    break;
                                case '18' || '18':
                                    $TiempoHorasDelDia['18'] =$TiempoHorasDelDia['18'] + $diferenciaSegundos ;
                                    break;
                                case ('19'||'19'):
                                    $TiempoHorasDelDia['19'] =$TiempoHorasDelDia['19'] + $diferenciaSegundos ;
                                    break;
                                case ('20'|| '20'):
                                    $TiempoHorasDelDia['20'] =$TiempoHorasDelDia['20'] + $diferenciaSegundos ;
                                    break;
                                case '21'||'21':
                                    $TiempoHorasDelDia['21'] =$TiempoHorasDelDia['21'] + $diferenciaSegundos ;
                                    break;
                                case '22'|| '22':
                                    $TiempoHorasDelDia['22'] =$TiempoHorasDelDia['22'] + $diferenciaSegundos ;
                                    break;
                                case '23' || '23':
                                    $TiempoHorasDelDia['23'] =$TiempoHorasDelDia['23'] + $diferenciaSegundos ;
                                    break;
                                case '24' || '24':
                                    $TiempoHorasDelDia['24'] =$TiempoHorasDelDia['24'] + $diferenciaSegundos ;
                                    break;
                                default:
                                $TiempoHorasDelDia['00'] =$TiempoHorasDelDia['00'] + $diferenciaSegundos ;
                                    break;
                            }

                            }
                            $tiempoFinal = $tiempoInicial = null;
                        }           
                        
                    }
                    
                    if($fechaInicial == null){
                        
                        for ($mes=01; $mes <12 ; $mes++) { 
                            for ($dia=01; $dia <31 ; $dia++) { 
                                $fechaBase = Carbon::parse("2021-".$mes."-".$dia)->toDateString();
                                $from = $fechaBase."T00:00:00.00";
                                $to   = $fechaBase."T23:59:59.999";
                                $PrimerAccionEnDia = Accion::where('device_id','=',$device->id)->whereBetween('created_at', [$from, $to])->orderBy('created_at','ASC')
                                ->first(); 
                                if($PrimerAccionGeneral == null){
                                    if($PrimerAccionEnDia != null){
                                        $UltimaAccionEnDia = Accion::where('device_id','=',$device->id)->whereBetween('created_at', [$from, $to])
                                                    ->orderBy('created_at','DESC')
                                                    ->first();
                                        if(
                                            $PrimerAccionEnDia !=""
                                            ){      
                                                $diferencia = ($PrimerAccionEnDia->created_at->diffInSeconds($UltimaAccionEnDia->created_at));
                                                $total = $total + $diferencia;
                                                
                                        }else{
                                            $total = $total + 0;
                                        }
                                    }
                                }
                                                
                                       
                            }
                        }
                    }else{
                        if($fechaInicial == "aN-aN-NaN"){
                            $fechaInicial=Accion::where('device_id','=',$device->id)->orderBy('created_at','ASC')
                            ->first();
                            $fechaInicial = $fechaInicial->created_at;
                            
                        }
                        if($fechaFinal == "aN-aN-NaN"){
                            $fechaFinal=Accion::where('device_id','=',$device->id)->orderBy('created_at','DESC')
                            ->first();
                            $fechaFinal = $fechaFinal->created_at;
                        }

                        $fechaInicial = (Carbon::parse($fechaInicial));
                        $fechaFinal = (Carbon::parse($fechaFinal));
                        $fechaCalculada = $fechaInicial->hour(0)->minute(0)->second(0);
                        
                        $fechaBase = $fechaInicial;
                        
                        while($fechaCalculada->diffInDays($fechaFinal) >= 0 ){
                        
                                $from = $fechaCalculada;
                                $to   = $fechaCalculada;
                                $PrimerAccionEnDia = Accion::whereBetween('created_at', [$from->hour(0)->minute(0)->second(0)->toDateTimeString(), $to->hour(23)->minute(59)->second(59)->toDateTimeString()])->orderBy('created_at','ASC')
                                ->first(); 
                                // dd($PrimerAccionEnDia);        
                                if($PrimerAccionGeneral == null){
                                    if($PrimerAccionEnDia != null){
                                        $UltimaAccionEnDia = Accion::whereBetween('created_at', [$from->hour(0)->minute(0)->second(0)->toDateTimeString(), $to->hour(23)->minute(59)->second(59)->toDateTimeString()])
                                                    ->orderBy('created_at','DESC')
                                                    ->first();
                                        if($PrimerAccionEnDia !="" && $UltimaAccionEnDia != null){      
                                            
                                                $diferencia = ($PrimerAccionEnDia->created_at->diffInSeconds($UltimaAccionEnDia->created_at));
                                                $total = $total + $diferencia;
                                        }else{
                                            $total = $total + 0;
                                        }
                                    }
                                }
                                
                                if($fechaCalculada == $fechaFinal->hour(23)->minute(59)->second(59)){
                                    break;
                                }else{
                                    $fechaCalculada = $fechaCalculada->addDay(1);
                                }
                        }
                        
                    }
                    
                    

                    
                    $MinutosDiasDeLaSemana[$indexDiasDeSemana] = $TiemposDiasDeLaSemana;
                    $DispositivosDiasDeLaSemana[$indexDiasDeSemana] = $interaccionesDiasDeLaSemana;
                    $DispositivosHorasDelDia[$indexDiasDeSemana] = $interaccionesHorasDelDia;
                    $MinutosHorasDelDia[$indexDiasDeSemana] = $TiempoHorasDelDia;
                    $indexDiasDeSemana++;
                    
                }
                
                    
            }
            
        
        // dd($total);
        
        
        $infos = collect();
        $fechaInicial = Carbon::parse($fechaInicialAuxiliar);
        $fechaFinal = Carbon::parse($fechaFinalAuxiliar);
        $infos->fechaInicial = $fechaInicial->addDay(1)->format("Y-m-d");
        $infos->fechaFinal = $fechaFinal->addDay(1)->format("Y-m-d");
        $infos->productosTotales =  (int)(($productosTotales));
        $rows = collect([
            ['Minutos en mano', $diff],
            ['Minutos en anaquel', $total],
        ]);
        // dd($rows[1][1]);
        
        $infos->productosConInteraccion =  (int)(($productosConInteraccion));
        // if($productosTotales != 0){
            if($productosTotales != 0){
                $infos->porcentajeInteracciones =  (int)(($productosConInteraccion*100)/ $productosTotales);
            }else{
                $infos->porcentajeInteracciones = 0;
            }
            
        // }
        // $infos->porcentajeInteracciones = 0;
        
        if($infos->productosConInteraccion == 0){
            $infos->tiempoEnAnaquel = 0;    
            $infos->tiempoEnMano = 0;
        }else {
            
        $infos->tiempoEnAnaquel =  (int)(($rows[1][1])/$infos->productosConInteraccion);
        $infos->tiempoEnMano =  (int)(($rows[0][1])/$infos->productosConInteraccion);
        }
        if($infos->tiempoEnAnaquel == 0){
            $infos->tiempoEnAnaquel = 0;
        }else{
            $infos->tiempoEnAnaquel = ($infos->tiempoEnAnaquel);
        }
        
        
        if($infos->tiempoEnAnaquel != 0 ){
            $infos->porcentajeDeTiempo =  (int)(($infos->tiempoEnMano*100)/ $infos->tiempoEnAnaquel);
        }else{
            $infos->porcentajeDeTiempo =  0;
        }
        
        if((($infos->tiempoEnAnaquel)-($infos->tiempoEnMano))> 0 ){
            $rows = collect([
                ['Minutos en mano', $infos->tiempoEnMano],
                ['Minutos en anaquel', ($infos->tiempoEnAnaquel)],
            ]);
        }else {
            $rows = collect([
                ['Minutos en mano', $infos->tiempoEnMano],
                ['Minutos en anaquel', 0],
            ]);
        }
        
        // dd($infos);
        
        $this->TopProductosGrafica($masLevantados);
        $this->DiasDeLaSemanaGrafica($DispositivosDiasDeLaSemana);
        $this->HorasGrafica($DispositivosHorasDelDia);
        $this->TiempoMano_TiempoAnaquel($rows);
        $this->TiempoManoSemanaGrafica($MinutosDiasDeLaSemana);
        $this->TiempoManoHorasGrafica($MinutosHorasDelDia);
        $fechaActual = (Carbon::now());
        $currentTeamId = Auth::user()->current_team_id;
        $categoriasPorEquipo = Categoria::where('team_id','=',$currentTeamId)->get();

        // Api SEEMETRIX

        $idUserSeemetrix = $categoria->api_user_id;
        $keyUserSeemetrix = $categoria->api_key_id;
        $DevicesIds = new Collection();
        $DevicesIds->push($categoria->api_device_id);
        
        $seemetrix = app('App\Http\Controllers\SeemetrixController')->getDataFromSeemetrix($idUserSeemetrix,$keyUserSeemetrix, $DevicesIds, $infos->fechaInicial, $infos->fechaFinal);
        return view ('analiticos',compact('infos', 'categoriasPorEquipo','DispositivosTodos', 'fechaActual', 'seemetrix'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}