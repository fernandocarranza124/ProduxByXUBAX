<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\TeamUser;
use App\Models\Team;
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
        if(count($user) != 0){
            // no es admin -> muestra solo sus dispositivos
            
            dd("no es admin");
        }else{
            // es admin -> muestra todos los dispositivos de ese grupo
            $dispositivosDeUsuariosEnGrupo = TeamUser::select('devices.*','team_user.*')
                                                    ->join('devices','team_user.user_id','=','devices.user_id')
                                                    ->where('team_user.team_id','=',Auth::user()->current_team_id)
                                                    ->get();
            // $dispositivosPropios = TeamUser::select('devices.*', 'team_user.*')
            $dispositivosPropios = Device::where('user_id','=',Auth::user()->id)->get();
            // dd($dispositivosDeUsuariosEnGrupo);
         return view('devices', compact('dispositivosDeUsuariosEnGrupo','dispositivosPropios'))->render();   
        }
        // $devices=Device::all();
        // dd($devices);
        

        // return view('devices',compact('devices'));
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
        $nombre = $request->input('nombre');
        $nombreAccion = $request->input('nombreAccion');
        $categoria = $request->input('categoria');
        $pin = $request->input('PIN');
        $Device = new Device;
            $Device->nombre=$nombre;
            $Device->nombreAccion=$nombreAccion;
            $Device->categoria=$categoria;
            $Device->pin=$pin;
            $Device->estado="Online";
            $Device->id_user=Auth::user()->id;
        $Device->save();
        return $Device->id;
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
