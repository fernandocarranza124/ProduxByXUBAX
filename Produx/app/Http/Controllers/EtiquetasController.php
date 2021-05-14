<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\TeamUser;
use App\Models\Team;
use App\Models\Categoria;
use App\Models\Etiqueta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EtiquetasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtiene las etiquetas que pertenecen al equipo donde se encuentre actualmente el usuario
        $etiquetas = Etiqueta::where('team_id','=',Auth::user()->current_team_id)
                        ->join('teams','etiquetas.team_id','=','teams.id')
                        ->join('users', 'etiquetas.user_id','=','users.id')
                        ->get(['etiquetas.id','etiquetas.color','etiquetas.nombre','etiquetas.user_id','etiquetas.team_id','etiquetas.created_at','teams.name as teamName','users.name as ownerName']);
        // Obtiene el usuario logeado
        $user = Auth::user();
        // Obtiene los grupos donde pertenece el usuario
        $teams = $user->teams;
        // Obtiene los grupos propios del usuario
        $ownedTeams = $user->ownedTeams;
        // Genera junta los dos valores y elimina los duplicados
        foreach ($ownedTeams as $team) {
            $teams->push($team);    
        }
        $teams = $teams->unique();
        // Obtiene el equipo donde se encuentra actualmente el usuario
        $team = Team::findOrFail(Auth::user()->current_team_id);
        // Obtiene los usuarios que pertenecen al equipo donde se encuentre actualmente
        $users = $team->allUsers();
        return view('etiquetas', compact('team','user','etiquetas','teams','users'))->render();  
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
        
        
        $etiqueta = new Etiqueta;
            $etiqueta->nombre =  $request->nameEtiqueta;
            $etiqueta->color =   $this->random_color($etiqueta->nombre);
            $etiqueta->user_id = Auth::user()->id;
            $etiqueta->team_id = Auth::user()->current_team_id;
            $etiqueta->save();
        
        return redirect()->route(('Etiquetas.index'));
    }

    
    
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
        $etiqueta = Etiqueta::findOrFail($id);
        $etiqueta->nombre = $request->nameEtiqueta;
        $etiqueta->team_id = $request->idGrupo;
        $etiqueta->save();
        return redirect()->route('Etiquetas.index')
                        ->with('success','Categoria actualizada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Etiqueta::find($id)->delete();
        return redirect()->route('Etiquetas.index')
                        ->with('success','Categoria eliminada con exito');
    }
}
