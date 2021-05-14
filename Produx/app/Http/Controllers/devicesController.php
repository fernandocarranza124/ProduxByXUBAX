<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\TeamUser;
use App\Models\Team;
use App\Models\Categoria;
use App\Models\Etiqueta;
use App\Models\Etiquetas_Pivote;
use App\Models\Pin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonInterval;


class devicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $teams = $user->teams;
        $ownedTeams = $user->ownedTeams;
        foreach ($ownedTeams as $team) {
            $teams->push($team);    
        }
        $teams = $teams->unique();
        $user = TeamUser::all()->where('team_id','=',Auth::user()->current_team_id)->where('user_id', '=',Auth::user()->id);
        $team= Team::findOrFail(Auth::user()->current_team_id);
        $users = $team->allUsers();
        $categorias = Categoria::where('team_id','=',Auth::user()->current_team_id)->get();
        // dd($categorias);
        if(count($user) != 0){
            // no es admin -> muestra solo sus dispositivos
            
            $user = Auth::user();
            $dispositivosPropios = Device::where('user_id','=',Auth::user()->id)->get();
            $etiquetas = Etiqueta::where('team_id','=',Auth::user()->current_team_id)->get();
            // Obtiene las etiquetas del cada uno de los dispositivos
            foreach ($dispositivosPropios as $dispositivo) {
                $allTags = Etiquetas_Pivote::where('device_id','=',$dispositivo->id)
                                                ->join('etiquetas','etiquetas_dispositivo.etiqueta_id','=','etiquetas.id')
                                                ->get();
                $dispositivo->allTags = $allTags;
            }
            $PinsAvailable = Pin::where('team_id','=',Auth::user()->current_team_id)
                                    ->where('active','=','0')
                                    ->get();
                                    return view('devices', compact('team','user','dispositivosPropios','categorias','etiquetas','teams','users','PinsAvailable'))->render();  
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
            // dd($dispositivosPropios);

            $etiquetas = Etiqueta::where('team_id','=',Auth::user()->current_team_id)->get();
            // Obtiene las etiquetas del cada uno de los dispositivos
            foreach ($dispositivosPropios as $dispositivo) {
                $allTags = Etiquetas_Pivote::where('device_id','=',$dispositivo->id)
                                                ->join('etiquetas','etiquetas_dispositivo.etiqueta_id','=','etiquetas.id')
                                                ->get();
                $dispositivo->allTags = $allTags;
            }
            foreach ($dispositivosDeUsuariosEnGrupo as $dispositivo) {
                $allTags = Etiquetas_Pivote::where('device_id','=',$dispositivo->id)
                                                ->join('etiquetas','etiquetas_dispositivo.etiqueta_id','=','etiquetas.id')
                                                ->get();
                $dispositivo->allTags = $allTags;
            }

            $PinsAvailable = Pin::where('team_id','=',Auth::user()->current_team_id)
                                    ->where('active','=','0')
                                    ->get();
            
            return view('devices', compact('team','user','dispositivosPropios','dispositivosDeUsuariosEnGrupo','categorias','etiquetas','teams','users','PinsAvailable'))->render();  
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
            $Device->pin_id=$request->PIN;
        $Device->save();
        $pin = Pin::findOrFail($request->PIN);
            $pin->active = 1;
            $pin->save();
        

        
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
    public function random_color($nombre) {
        $colors = array("red","yellow","green","blue","indigo","purple","pink");
        $colores = array("rojo","amarillo","verde","azul","indigo","morado","rosa");
        $gradientes = array("100","200","300","400","500","600","700");
        $indice = 0;
        foreach($colores as $color) {
            if (stripos($nombre,$color) !== false){
                return ($colors[$indice]."-".$gradientes[rand(0,6)]);
            }
            $indice++; 
            
        }
        return ($colors[rand(0,6)]."-".$gradientes[rand(0,6)]);
        
    }

    public function update(Request $request, $id)
    {
        $Device = $this->updateDevice($id, $request);
        $this->updateTagsChanged($Device, $request) ;
        $this->createAndLinkNewTags($request, $id);
        return redirect()->route(('Devices.index'));
        
    }
    public function createAndLinkNewTags($request, $id){
        $nuevasEtiquetas = explode(',',$request->addEtiquetas);
        foreach ($nuevasEtiquetas as $etiquetaNombre) {
            // Crear etiqueta
                // Comprueba si existe una con el mismo nombre
                    if(!$this->tagNameExist($etiquetaNombre, $id)){
                        $etiqueta = new Etiqueta;
                        $etiqueta->nombre = $etiquetaNombre;
                        $etiqueta->user_id = Auth::user()->id;
                        $etiqueta->team_id = Auth::user()->current_team_id;
                        $etiqueta->color = $this->random_color($etiquetaNombre);
                        $etiqueta->save();
                        // Una vez creada la etiqueta se vincula
                        $relation = new Etiquetas_Pivote;
                        $relation->device_id = $id;
                        $relation->etiqueta_id =$etiqueta->id ;
                        $relation->save();
                    }
                    
            

        }
    }
    public function tagNameExist($tagName, $id){
        
        $etiqueta = Etiqueta::where('nombre','=',$tagName)->get();
        
        if($etiqueta->isEmpty()){
            return false;
        }else{
            // Si ya existe, crea las relaciones
            
            $tag = $etiqueta->first();
            
            // Revisa si ya existe la relacion
            $relation = Etiquetas_Pivote::where('device_id','=',$id)
                                    ->where('etiqueta_id','=',$tag->id)
                                    ->get();
            if($relation->isEmpty()){
                $relation = new Etiquetas_Pivote;
                        $relation->device_id = $id;
                        $relation->etiqueta_id =$tag->id ;
                        $relation->save();    
            }
            return true;
            
        }

    }
    public function updateTagsChanged($Device, $request){
        $etiquetasViejas = Etiquetas_Pivote::where('device_id','=',$Device->id)->get();
            $viejas = array();
            foreach ($etiquetasViejas as $vieja) {
                $viejas[] = $vieja->etiqueta_id;
            }
        $etiquetasViejas = $viejas;
        $etiquetasNuevas = $request->etiquetas;
        $result = array_diff($etiquetasViejas, $etiquetasNuevas);
        foreach ($result as $etiquetaId) {
            $this->unLinkTag($etiquetaId);
        }
    }
    public function unLinkTag($id){
        $relation=Etiquetas_Pivote::where('etiqueta_id','=',$id);
        $relation->delete();
    }
    public function updateDevice($id, $request){
        $Device = Device::findOrFail($id);
            $Device->nombre = $request->nameDevice;
            $Device->categoria_id = $request->idCategoria;
            $Device->nombre = $request->nameDevice;
        $Device->save();
        return $Device;
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
            $pin = Pin::findOrFail($device->pin_id);
            $pin->active = 0;
            $pin->save();
        $device->delete();
        
        return redirect()->route(('Devices.index'));
    }
    public function soldProduct($idDevice){
        Carbon::setLocale('es');
        
        $device=Device::findOrFail($idDevice);
            $device->fecha_vendido = Carbon::now();
            $device->vendido = 1;
        $device->save();
        return "ok";
    }
}
