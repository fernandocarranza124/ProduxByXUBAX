<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ShowDevices extends Component
{
    public $estado;
    public $id;
    public $nombre;
    public $categoria;
    public $nombreAccion;
    public $pin;
    public $id_user;
    public $colorEstado;
    public $fechaCreacion;
    public $allTags;
    public $update;
    public $delete;
    public $teamRole;
    public $teams;
    public $users;
    public $categorias;
    public function __construct($device, $teams, $users, $categorias)
    {
        $this->categorias = $categorias;
        $this->teams = $teams;
        $this->users = $users;
        $this->allTags = $device->allTags;
        $this->estado = $device->estado;
        $this->id = $device->id;
        $this->nombre = $device->nombre;
        $this->categoria = $device->categoriaNombre;
        $this->nombreAccion = $device->nombreAccion;
        $this->pin = $device->pin;
        $this->id_user = $device->id_user; 
        $fecha = \Carbon\Carbon::parse($device->created_at);
        $this->update = $device->update;
        $this->delete = $device->delete;
        $this->teamRole = $device->teamRole;
        
        // 
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = \Carbon\Carbon::parse($device->created_at);
        $mes = $meses[($fecha->format('n')) - 1];
        $this->fechaCreacion = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
        // 
        if($this->estado == "Online"){
            $this->colorEstado = "green";
        }else if($this->estado == "Offline"){
            $this->colorEstado = "red";
        }else{     
            $this->colorEstado = "blue";
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // dd($estado);
        return view('components.show-devices');
    }
}
