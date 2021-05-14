<?php

namespace App\View\Components;

use Illuminate\View\Component;

class filtroAnaliticos extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $titulo;
    public $rows;
    public $id;
    public $fechaActual;
    public function __construct($titulo ,$rows, $id, $fechaActual)
    {
        $this->titulo = $titulo;
        $this->rows = $rows;
        $this->id = $id;
        $this->fechaActual = $fechaActual;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.filtro-analiticos');
    }
}
