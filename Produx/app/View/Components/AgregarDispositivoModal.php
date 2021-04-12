<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AgregarDispositivoModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $etiquetas;
    public $categorias;
    public $pins;
    public function __construct($etiquetas, $categorias, $pins)
    {
        $this->etiquetas = $etiquetas;
        $this->categorias = $categorias;
        $this->pins = $pins;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.agregar-dispositivo-modal');
    }
}
