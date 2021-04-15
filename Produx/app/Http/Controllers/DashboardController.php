<?php

namespace App\Http\Controllers;

use App\Models\Accion;
use App\Models\Device;
use App\Models\TeamUser;
use App\Models\Acciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = TeamUser::all()->where('team_id','=',Auth::user()->current_team_id)->where('user_id', '=',Auth::user()->id);
        if(count($user) != 0){
            $user = Auth::user();
            $dispositivosPropios = Device::where('user_id','=',Auth::user()->id)->get();
            $dispositivos = ($dispositivosPropios->count());
            $acciones = $this->getActionsByDates($dispositivosPropios);
        }else{
            // es admin -> muestra todos los dispositivos de ese grupo
            $user = Auth::user();
            $dispositivosDeUsuariosEnGrupo = TeamUser::select('devices.*','team_user.*')
                                                    ->join('devices','team_user.user_id','=','devices.user_id')
                                                    ->join('categorias','devices.categoria_id','=','categorias.id')
                                                    ->where('team_user.team_id','=',Auth::user()->current_team_id)
                                                    ->get();
                                                                
            // $dispositivosPropios = TeamUser::select('devices.*', 'team_user.*')
            $dispositivosPropios = Device::select('devices.*','categorias.nombre as categoriaNombre')
                                    ->where('devices.user_id','=',Auth::user()->id)
                                    ->join('categorias','devices.categoria_id','=','categorias.id')
                                    ->get();
            
            $dispositivos = ($dispositivosPropios->count()) + ($dispositivosDeUsuariosEnGrupo->count());
            $accionesDeUsuariosEnGrupo = $this->getActionsByDates($dispositivosDeUsuariosEnGrupo);

            $acciones = $this->getActionsByDates($dispositivosPropios);
            $acciones->accionesTotales =$acciones->accionesTotales + $accionesDeUsuariosEnGrupo->accionesTotales;
            $acciones->accionesPorDia = $acciones->accionesPorDia + $accionesDeUsuariosEnGrupo->accionesPorDia;
            $acciones->accionesPorMes = $acciones->accionesPorMes + $accionesDeUsuariosEnGrupo->accionesPorMes;
            $acciones->accionesPorHora = $acciones->accionesPorHora + $accionesDeUsuariosEnGrupo->accionesPorHora;
        }
        
        
        return view('dashboard',compact('dispositivos','acciones'));
        return view('devices', compact('team','user','dispositivosPropios','dispositivosDeUsuariosEnGrupo','categorias','etiquetas','teams','users','PinsAvailable'))->render();  
    }
    public function getActionsByDates($dispositivos){
        date_default_timezone_set ("America/Mexico_City");

        $accionesTotales=0;
        $accionesHora=0;
        $accionesDia=0;
        $accionesMes=0;
        $horaActual=date("Y-m-d H:i:s");
        $horaActualCerrada = substr($horaActual, 0,14).'00:00';
        $DiaActual = $horaActualCerrada;
        $DiaActualCerrada = substr($DiaActual, 0,11).'00:00:00';
        $MesActual = $horaActual;
        
        $MesActualCerrada = substr($MesActual, 0,8).'01 00:00:00';

        $Tiempos = 0;
        $tiempoInicial = 0;
        $tiempoFinal = 0;
        $diff = 0; 
        $contador=1;
        foreach ($dispositivos as $device) {
            $accion = Accion::where('device_id','=',$device->id)->get();
                foreach($accion as $iteracion){
                    if($iteracion->tipo == 0){
                        $tiempoInicial = $iteracion->created_at;
                        $contador++;
                    }else{
                        $tiempoFinal = $iteracion->created_at;
                        
                        // $diff = $diff + $tiempoInicial->diffInSeconds($tiempoFinal);
                        $tiempoFinal = $tiempoInicial = 0;
                        
                        
                    }
                    
                }
            
            
            $accionPorHora = Accion::whereBetween('created_at', [$horaActualCerrada, $horaActual])
                                ->where('device_id','=',$device->id)
                                ->get();
            $accionPorDia = Accion::whereBetween('created_at', [$DiaActualCerrada, $horaActual])
                ->where('device_id','=',$device->id)
                ->get();
            
            $accionPorMes = Accion::whereBetween('created_at', [$MesActualCerrada, $horaActual])
                            ->where('device_id','=',$device->id)
                            ->get();
            
        
            
            $accionesTotales = $accionesTotales + $accion->count(); 
            $accionesHora = $accionesHora + $accionPorHora->count();
            $accionesDia = $accionesDia + $accionPorDia->count();
            $accionesMes = $accionesMes + $accionPorMes->count();
        }
        
        $acciones = collect();
        $acciones->accionesTotales =  (Int)(($accionesTotales)/2);
        $acciones->accionesPorDia =  (Int)($accionesDia/2);
        $acciones->accionesPorMes = (Int)($accionesMes/2);
        $acciones->accionesPorHora = (Int)($accionesHora/2);
        $acciones->promedio = (Int)($diff/$contador);
        return $acciones;
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
