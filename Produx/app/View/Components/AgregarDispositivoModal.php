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
    public function __construct($etiquetas, $categorias)
    {
        $this->etiquetas = $etiquetas;
        $this->categorias = $categorias;
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
