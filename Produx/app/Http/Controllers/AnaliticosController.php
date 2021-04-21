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
        if($tiempoInicial == 0 && $tiempoFinal ==0){
            
        }
        if($categorias == 0){
            $currentTeamId = Auth::user()->current_team_id;
            $categoriasPorEquipo = Categoria::where('team_id','=',$currentTeamId)->get();
            foreach ($categoriasPorEquipo as $categoria) {
                $devices = Device::where('categoria_id','=',$categoria->id)->get();
                foreach ($devices as $device) {
                    $acciones = Accion::where('device_id','=',$device->id)->get();
                    foreach ($acciones as $accion) {
                        if ($accion->tipo == 0) {
                            $tiempoInicial = $accion->created_at;
                            $contador++;
                        } else if ($accion->tipo == 1) {
                            $tiempoFinal = $accion->created_at;
                            if ($tiempoInicial) {
                                
                                $diff = $diff +  $tiempoInicial->diffInMinutes($tiempoFinal);
                            }
                            $tiempoFinal = $tiempoInicial = 0;
                        }           
                    }
                    for ($i=0; $i <31 ; $i++) { 
                        $PrimerAccionEnDia = Accion::where('created_at', '>=', Carbon::now()->subDays($i)->toDateTimeString())
                                        ->orderBy('created_at','ASC')
                                        ->first();    
                        $UltimaAccionEnDia = Accion::where('created_at', '>=', Carbon::now()->subDays($i)->toDateTimeString())
                            ->orderBy('created_at','DESC')
                            ->first();
                            if(
                                $PrimerAccionEnDia !=""
                                ){
                                
                                $total = $total + ($PrimerAccionEnDia->created_at->diffInMinutes($UltimaAccionEnDia->created_at));
                            }else{
                                $total = $total + 0;
                                
                            }
                            
                            
                        
                    }
                    
                    

                }
            }
            
        }else{
            
            
        }
        
        $accion = Accion::where('device_id', '=', $tiempoEnMano)->get();
        foreach ($accion as $iteracion) {

            if ($iteracion->tipo == 0) {
                $tiempoInicial = $iteracion->created_at;

                $contador++;
            } else if ($iteracion->tipo == 1) {
                $tiempoFinal = $iteracion->created_at;
                if ($tiempoInicial) {
                    // echo ($diff." iteracion ".$contador);
                    // echo ("<br>");
                    $diff = $diff +  $tiempoInicial->diffInSeconds($tiempoFinal);
                }

                // dd($diff);
                $tiempoFinal = $tiempoInicial = 0;
            }
        }

$population = Lava::DataTable();

$population->addDateColumn('Day of Month')
->addNumberColumn('Tiempo en mano')
->addNumberColumn('Tiempo en anaquel')
->setDateTimeFormat('Y')
->addRow(["20", 1000, 400]);


Lava::ColumnChart('Population', $population, [
    'title' => 'Tiempo en mano - Tiempo en anaquel',
    'legend' => 'none',
    'vAxis' => [
        'title'=>'Minutos'
    ],
    'height' => 400,
    // 'hAxis' => [
    //     'title'=>'otros'
    // ],
    
    
]);

$levantamientosVsReposo = Lava::DataTable();

$levantamientosVsReposo->addStringColumn('Interaccion')
->addNumberColumn('Tiempo')
->addRow(["Tiempo en mano", $diff])
->addRow(["Tiempo en anaquel", $total]);



Lava::PieChart('levantamientosVSReposo', $levantamientosVsReposo, [
    'title' => 'Tiempo en mano - Tiempo en anaquel',
    'legend' => 'in',
    'vAxis' => [
        'title'=>'Minutos'
    ],
    'hAxis' => [
        'title'=>'Minutos'
    ],
    'height' => 400,
    'pieSliceText' => 'value',
    'is3D'   => true,
    'slices' => [
        ['offset' => 0.2],
        ['offset' => 0.25],
        ['offset' => 0.3]
    ]
    
    
]);



        $year = ['2015','2016','2017','2018','2019','2020','2021'];

        $user = [];
        foreach ($year as $key => $value) {
            $user[] = User::where(DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->count();
        }
    	// return view('chartjs')->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('user',json_encode($user,JSON_NUMERIC_CHECK));
        // $year =(json_encode($year));
        // dd($year);
        // $user =(json_encode($user, JSON_NUMERIC_CHECK));
        return view ('analiticos',compact('year', 'user'))->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('user',json_encode($user,JSON_NUMERIC_CHECK));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
