<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GeneralAnaliticos extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    
    public $infos;
    public $dispositivos;
    public $categorias;
    public $fechaActual;
    public function __construct($infos, $dispositivos, $categorias, $fechaActual)
    {
        $this->infos = $infos;
        $this->dispositivos = $dispositivos;
        $this->categorias = $categorias;
        $this->fechaActual = $fechaActual;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.general-analiticos');
    }
}
