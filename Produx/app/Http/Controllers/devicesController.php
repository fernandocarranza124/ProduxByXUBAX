<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\TeamUser;
use App\Models\Team;
use App\Models\Categoria;
use App\Models\Etiqueta;
use App\Models\Etiquetas_Pivote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class devicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = TeamUser::all()->where('team_id','=',Auth::user()->current_team_id)->where('user_id', '=',Auth::user()->id);
        $team= Team::findOrFail(Auth::user()->current_team_id);
        $categorias = Categoria::where('team_id','=',Auth::user()->current_team_id)->get();
        // dd($categorias);
        if(count($user) != 0){
            // no es admin -> muestra solo sus dispositivos
            
            $user = Auth::user();
            $dispositivosPropios = Device::where('user_id','=',Auth::user()->id)->get();
            return view('devices', compact('team','user','dispositivosPropios'))->render();      
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
            dd($dispositivosPropios);

            $etiquetas = Etiqueta::where('team_id','=',Auth::user()->current_team_id)->get();
            return view('devices', compact('team','user','dispositivosPropios','dispositivosDeUsuariosEnGrupo','categorias','etiquetas'))->render();  
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input('ubicacion'));
        // Agregar insercion a etiquetas
        $Device = new Device;
            $Device->nombre=$request->input('nameDevice');
            $Device->categoria_id=$request->input('categoria');
            $Device->pin_id=$request->input('PIN');
            $Device->upc=$request->input('UPC');
            $Device->user_id=Auth::user()->id;
            $Device->estado='Online';
        $Device->save();
        
        foreach ($request->etiquetas as $etiqueta) {
            $etiqueta_Dispositivo = new Etiquetas_Pivote;
            $etiqueta_Dispositivo->device_id = $Device->id;
            $etiqueta_Dispositivo->etiqueta_id = $etiqueta;
            $etiqueta_Dispositivo->save();
        }

        
        return redirect()->route(('Devices.index'));
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
        $device=Device::findOrFail($id);
        $device->delete();
        return redirect()->route(('Devices.index'));
    }
}
