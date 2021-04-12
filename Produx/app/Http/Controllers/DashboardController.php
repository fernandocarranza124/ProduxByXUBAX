<?php

namespace App\Http\Controllers;
use App\Models\Device;
use App\Models\TeamUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        }
        $DispositivosTotal = ($dispositivosPropios->count()) + ($dispositivosDeUsuariosEnGrupo->count());
        return view('dashboard',compact('DispositivosTotal'));
        return view('devices', compact('team','user','dispositivosPropios','dispositivosDeUsuariosEnGrupo','categorias','etiquetas','teams','users','PinsAvailable'))->render();  
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
