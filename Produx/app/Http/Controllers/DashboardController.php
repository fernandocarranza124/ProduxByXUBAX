<?php

namespace App\Http\Controllers;

use App\Models\Accion;
use App\Models\Device;
use App\Models\TeamUser;
use App\Models\Acciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonInterval;

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
        $user = TeamUser::all()->where('team_id', '=', Auth::user()->current_team_id)->where('user_id', '=', Auth::user()->id);
        if (count($user) != 0) {
            $user = Auth::user();
            $dispositivosPropios = Device::where('user_id', '=', Auth::user()->id)->get();
            $dispositivos = ($dispositivosPropios->count());

            $acciones = $this->getActionsByDates($dispositivosPropios);
        } else {
            // es admin -> muestra todos los dispositivos de ese grupo
            $user = Auth::user();
            $dispositivosDeUsuariosEnGrupo = TeamUser::select('devices.*', 'team_user.*')
                ->join('devices', 'team_user.user_id', '=', 'devices.user_id')
                ->join('categorias', 'devices.categoria_id', '=', 'categorias.id')
                ->where('team_user.team_id', '=', Auth::user()->current_team_id)
                ->get();

            // $dispositivosPropios = TeamUser::select('devices.*', 'team_user.*')
            $dispositivosPropios = Device::select('devices.*', 'categorias.nombre as categoriaNombre')
                ->where('devices.user_id', '=', Auth::user()->id)
                ->join('categorias', 'devices.categoria_id', '=', 'categorias.id')
                ->get();

            $dispositivos = ($dispositivosPropios->count()) + ($dispositivosDeUsuariosEnGrupo->count());

            $accionesDeUsuariosEnGrupo = $this->getActionsByDates($dispositivosDeUsuariosEnGrupo);

            $acciones = $this->getActionsByDates($dispositivosPropios);
            // dd($accionesDeUsuariosEnGrupo);
            $acciones->accionesTotales = $acciones->accionesTotales + $accionesDeUsuariosEnGrupo->accionesTotales;
            $acciones->accionesPorDia = $acciones->accionesPorDia + $accionesDeUsuariosEnGrupo->accionesPorDia;
            $acciones->accionesPorMes = $acciones->accionesPorMes + $accionesDeUsuariosEnGrupo->accionesPorMes;
            $acciones->accionesPorHora = $acciones->accionesPorHora + $accionesDeUsuariosEnGrupo->accionesPorHora;
            $acciones->productosEnMano = $acciones->productosEnMano + $accionesDeUsuariosEnGrupo->productosEnMano;
            $acciones->productosEnAnaquel = $acciones->productosEnAnaquel + $accionesDeUsuariosEnGrupo->productosEnAnaquel;
            $acciones->productosRobados = $acciones->productosRobados + $accionesDeUsuariosEnGrupo->productosRobados;
            if ($acciones->productoMayorInteraccionDia->NumeroInteracciones < $accionesDeUsuariosEnGrupo->productoMayorInteraccionDia->NumeroInteracciones) {
                $acciones->productoMayorInteraccionDia = $accionesDeUsuariosEnGrupo->productoMayorInteraccionDia;
            }
        }


        return view('dashboard', compact('dispositivos', 'acciones'));
        return view('devices', compact('team', 'user', 'dispositivosPropios', 'dispositivosDeUsuariosEnGrupo', 'categorias', 'etiquetas', 'teams', 'users', 'PinsAvailable'))->render();
    }
    public function getActionsByDates($dispositivos)
    {
        Carbon::setLocale('es');
        date_default_timezone_set("America/Mexico_City");

        $accionesTotales = 0;
        $accionesHora = 0;
        $accionesDia = 0;
        $accionesMes = 0;
        $horaActual = date("Y-m-d H:i:s");
        $horaActualCerrada = substr($horaActual, 0, 14) . '00:00';
        $DiaActual = $horaActualCerrada;
        $DiaActualCerrada = substr($DiaActual, 0, 11) . '00:00:00';
        $MesActual = $horaActual;

        $MesActualCerrada = substr($MesActual, 0, 8) . '01 00:00:00';

        $Tiempos = 0;
        $tiempoInicial = 0;
        $tiempoFinal = 0;
        $diff = null;
        $contador = 1;

        $productoEnMano = 0;
        $productoEnAnaquel = 0;
        $productoMayorDia = collect();
        $productoMayorDia->device = null;
        $productoMayorDia->NumeroInteracciones = null;
        $productoMayorMes = collect();
        $productoMayorMes->device = null;
        $productoMayorMes->NumeroInteracciones = null;
        $sumaInteraccionConcluida = CarbonInterval::months(0);
        $vendidosPorDia = 0;
        $vendidosPorMes = 0;
        foreach ($dispositivos as $device) {

            $accion = Accion::where('device_id', '=', $device->id)->get();
            $ultimaAccion = Accion::where('device_id', '=', $device->id)->orderByDesc('created_at')->first();
            if ($ultimaAccion->tipo == 1) {
                $productoEnMano++;
            } else {
                $productoEnAnaquel++;
            }
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
            $accionPorHora = Accion::whereBetween('created_at', [$horaActualCerrada, $horaActual])
                ->where('device_id', '=', $device->id)
                ->get();
            $accionPorDia = Accion::whereBetween('created_at', [$DiaActualCerrada, $horaActual])
                ->where('device_id', '=', $device->id)
                ->get();

            $accionPorMes = Accion::whereBetween('created_at', [$MesActualCerrada, $horaActual])
                ->where('device_id', '=', $device->id)
                ->get();
            if ($productoMayorDia->count() > 0) {
                $productoMayorDia->device = $device->nombre;
                $productoMayorDia->NumeroInteracciones = $accionPorDia->count() / 2;
                $productoMayorDia->NumeroInteracciones = (int)$productoMayorDia->NumeroInteracciones;
            } else if ($accionPorDia->count() > $productoMayorDia->NumeroInteracciones) {
                $productoMayorDia->device = $device->nombre;
                $productoMayorDia->NumeroInteracciones = $accionPorDia->count() / 2;
                $productoMayorDia->NumeroInteracciones = (int)$productoMayorDia->NumeroInteracciones;
            }
            if ($productoMayorMes->count() > 0) {
                $productoMayorMes->device = $device->nombre;
                $productoMayorMes->NumeroInteracciones = $accionPorMes->count() / 2;
                $productoMayorMes->NumeroInteracciones = (int)$productoMayorMes->NumeroInteracciones;
            } else if ($accionPorMes->count() > $productoMayorMes->NumeroInteracciones) {
                $productoMayorMes->device = $device->nombre;
                $productoMayorMes->NumeroInteracciones = $accionPorMes->count() / 2;
                $productoMayorMes->NumeroInteracciones = (int)$productoMayorMes->NumeroInteracciones;
            }

            $accionesTotales = $accionesTotales + $accion->count();
            $accionesHora = $accionesHora + $accionPorHora->count();
            $accionesDia = $accionesDia + $accionPorDia->count();
            $accionesMes = $accionesMes + $accionPorMes->count();
            foreach ($accionPorDia as $accion) {
                if($accion->tipo == 2){
                    $vendidosPorDia++;
                }
            }
            foreach ($accionPorMes as $accion) {
                if($accion->tipo == 2){
                    $vendidosPorDia++;
                }
            }
        }
        $porcentajeDia = 0;
        $porcentajeMes = 0;
        if($accionesDia != 0){
            $porcentajeDia = ($vendidosPorDia/$accionesDia);    
        }
        if($accionesMes != 0){
            $porcentajeMes = ($vendidosPorMes/$accionesMes);    
        }
        
        $sumaInteraccionConcluida = ($sumaInteraccionConcluida->plus(0, 0, 0, 0, 0, 0, $diff / ($contador / 2))->cascade()->forHumans());
        $acciones = collect();
        $acciones->accionesTotales =  (int)(($accionesTotales) / 2);
        $acciones->accionesPorDia =  (int)($accionesDia / 2);
        $acciones->accionesPorMes = (int)($accionesMes / 2);
        $acciones->accionesPorHora = (int)($accionesHora / 2);
        $acciones->promedio = (int)($diff / $contador);
        $acciones->productosEnMano = $productoEnMano;
        $acciones->productosEnAnaquel = $productoEnAnaquel;
        $acciones->productosRobados = 0;
        $acciones->productoMayorInteraccionDia = $productoMayorDia;
        $acciones->productoMayorInteraccionMes = $productoMayorMes;
        $acciones->tiempoPromedioInteraccion = $sumaInteraccionConcluida;
        $acciones->porcentajeDia = $porcentajeDia;
        $acciones->porcentajeMes = $porcentajeMes;

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
