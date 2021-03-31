<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\TeamUser;
use App\Models\Team;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Muestra las categorias que estén registradas por el o algun miembro del grupo
        $team= Team::findOrFail(Auth::user()->current_team_id);
        $user = Auth::user();
        // dd($team->allUsers());
        $Miembros = $team->allUsers();
        $categorias = Categoria::where('team_id','=',Auth::user()->current_team_id)->get();
        // dd($categorias);
        
        return view('categorias', compact('team','user','categorias'))->render();  
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
        // dd("llego");
        $categoria = new Categoria;
            $categoria->Nombre = $request->input('nameCategoria');
            $categoria->user_id = Auth::user()->id;
            $categoria->team_id = Auth::user()->current_team_id;
        $categoria->save();
        return redirect()->route(('Categorias.index'));
        return $categoria;
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
