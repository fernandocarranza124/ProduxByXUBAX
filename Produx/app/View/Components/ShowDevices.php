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
    public function __construct($device)
    {
        $this->estado = $device->estado;
        $this->id = $device->id;
        $this->nombre = $device->nombre;
        $this->categoria = $device->categoria;
        $this->nombreAccion = $device->nombreAccion;
        $this->pin = $device->pin;
        $this->id_user = $device->id_user; 

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
