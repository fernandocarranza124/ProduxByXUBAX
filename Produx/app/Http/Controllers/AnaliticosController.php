<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Lava;
use App\Models\User;
use App\Models\Accion;
use App\Models\Categoria;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Khill\Lavacharts\Laravel\LavachartsFacade;
use Khill\Lavacharts\Lavacharts;



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
        $total = 0;
        $diff = 0;
        $contador = 0;
        $indexDiasDeSemana = 0;
        $productosTotales = 0;
        $productosConInteraccion = 0;
        $DispositivosDiasDeLaSemana = collect();
        $DispositivosHorasDelDia = collect();
        $MinutosDiasDeLaSemana = collect();
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
            foreach ($categoriasPorEquipo as $categoria) {
                $devices = Device::where('categoria_id','=',$categoria->id)->get();
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
                                $diff = $diff +  $diferencia;
                                $dayOfTheWeek = $tiempoInicial->dayOfWeek;
                                
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

                            }
                            $tiempoFinal = $tiempoInicial = 0;
                        }           
                        
                    }

                    

                    for ($mes=01; $mes <12 ; $mes++) { 
                        for ($dia=01; $dia <31 ; $dia++) { 
                            $fechaBase = Carbon::parse("2021-".$mes."-".$dia)->toDateString();
                            $from = $fechaBase."T00:00:00.00";
                            $to   = $fechaBase."T23:59:59.999";
                            $PrimerAccionEnDia = Accion::whereBetween('created_at', [$from, $to])
                                            ->orderBy('created_at','ASC')
                                            ->first(); 
                            if($PrimerAccionEnDia != null){
                                
                                $UltimaAccionEnDia = Accion::whereBetween('created_at', [$from, $to])
                                            ->orderBy('created_at','DESC')
                                            ->first();
                                if(
                                    $PrimerAccionEnDia !=""
                                    ){      
                                        $diferencia = ($PrimerAccionEnDia->created_at->diffInMinutes($UltimaAccionEnDia->created_at));
                                        $total = $total + $diferencia;
                                        
                                }else{
                                    $total = $total + 0;
                                }
                            }       
                        }
                    }
                    
                    
                    
                    $MinutosDiasDeLaSemana[$indexDiasDeSemana] = $TiemposDiasDeLaSemana;
                    $DispositivosDiasDeLaSemana[$indexDiasDeSemana] = $interaccionesDiasDeLaSemana;
                    $DispositivosHorasDelDia[$indexDiasDeSemana] = $interaccionesHorasDelDia;
                    $indexDiasDeSemana++;
                    
                }
                
                    
            }
            
        }else{
            
            
        }
        
        $rows = collect([
            ['Tiempo en mano', $diff],
            ['Tiempo en anaquel', $total],
        ]);
        $infos = collect();
        $infos->productosTotales =  (int)(($productosTotales));
        $infos->productosConInteraccion =  (int)(($productosConInteraccion));
        $infos->porcentajeInteracciones =  (int)(($productosConInteraccion*100)/ $productosTotales);
        $infos->tiempoEnAnaquel =  (int)($rows[1][1]);
        $infos->tiempoEnMano =  (int)(($rows[0][1]));
        if($infos->tiempoEnAnaquel != 0 ){
            $infos->porcentajeDeTiempo =  (int)(($infos->tiempoEnMano*100)/ $infos->tiempoEnAnaquel);
        }else{
            $infos->porcentajeDeTiempo =  0;
        }
        
        // dd($infos);
        $this->TopProductosGrafica($masLevantados);
        $this->DiasDeLaSemanaGrafica($DispositivosDiasDeLaSemana);
        $this->HorasGrafica($DispositivosHorasDelDia);
        $this->TiempoMano_TiempoAnaquel($rows);
        $this->TiempoManoSemanaGrafica($MinutosDiasDeLaSemana);
        return view ('analiticos',compact('infos'));
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
                array_push($arreglo, $rows[$i][$weekMap[$indexWeekDay]]["Mano"]);   
            }
            
            $indexWeekDay++;
            $grafica->addRow($arreglo);
        }
        $grafica->setDateTimeFormat('l');
        Lava::ColumnChart('TiemposDiasDeLaSemana', $grafica, [
            'title' => 'Tiempos de interaccion durante los dias de la semana',
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
            'legend' => 'bottom',
        ]);
    }
    
    public function TiempoMano_TiempoAnaquel($rows){
        $grafica = Lava::DataTable();
        $grafica->addStringColumn('Interaccion')
                                ->addNumberColumn('Tiempo');
                                foreach ($rows as $row) {
                                    $grafica->addRow([$row[0]  ,$row[1]]);
                                }
        Lava::PieChart('levantamientosVSReposo', $grafica, [
                        'colors'=> ['#2d6b22', '#8ab446', '#ec8f6e', '#f3b49f', '#f6c7b6'],
                        'title' => 'Tiempo en mano - Tiempo en anaquel',
                        // 'legend' => 'in',
                        'vAxis' => [
                            'title'=>'Minutos'
                        ],
                        'hAxis' => [
                            'title'=>'Minutos'
                        ],
                        'height' => 280,
                        'pieSliceText' => 'value',
                        'is3D'   => true,
                        'slices' => [
                            
                        ]
                        // ['offset' => 0.2],
                        // ['offset' => 0.25],
                        // ['offset' => 0.3]
                        
                    ]);
    }
    public function TopProductosGrafica($rows){
        $grafica = Lava::DataTable();
            $grafica->addStringColumn('dispositivo')->addNumberColumn('Interacciones');
        // foreach ($rows as $row) {
        //     $grafica->addRow([$row['dispositivo']  ,$row['cantidad']]);
        // }
        for ($i=0; $i <count($rows) ; $i++) { 
            if ($rows[$i]['dispositivo'] != null) {
                $grafica->addRow([
                    $rows[$i]['dispositivo'],
                    (int)((int)($rows[$i]['cantidad'])/2) ]);    
            }
            
        }
        Lava::ColumnChart('TopMasInteracciones', $grafica, [
            'title' => 'Productos con mayor interacción',
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ],
            'vAxis' => [
                'title'=>'Minutos'
            ],
            'hAxis' => [
                'title'=>'Productos'
            ],
            'height' => 280,
            'pieSliceText' => 'value',
            'is3D'   => true,
            'slices' => [
                
            ],
            'legend' => 'in',
        ]);
    }
    public function DiasDeLaSemanaGrafica($rows){

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

            // ->addRow(['Mie', 660, 1120,1])
            // ->addRow(['Jue', 660, 1120,123])
            // ->addRow(['Vie', 660, 1120,908])
            // ->addRow(['Sab', 660, 1120,346])
            // ->addRow(['Dom', 1030, 54,456]);
        
        Lava::ColumnChart('ProductosInteraccionesDiasDeLaSemana', $grafica, [
            'title' => 'Interacciones durante los dias de la semana',
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
            'legend' => 'bottom',
        ]);
    }

    public function HorasGrafica($rows){
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
            // $grafica->addNumberColumn('iPhone 12 Pro')
            // ->addNumberColumn('Huawei Mate 10 Pro')
            // ->addNumberColumn('Xiaomi Mi10T Pro')
            
            // ->addRow(['08', 1000, 400,300])
            // ->addRow(['09', 1170, 460,450])
            // ->addRow(['10', 660, 1120,1])
            // ->addRow(['11', 660, 1120,123])
            // ->addRow(['12', 660, 1120,908])
            // ->addRow(['13', 660, 1120,346])
            // ->addRow(['14', 1030, 54,456]);
        
        Lava::ColumnChart('ProductosInteraccionesHorasAlDia', $grafica, [
            
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
            'legend' => 'bottom',
        ]);
    }
    public function create()
    {
        //
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
