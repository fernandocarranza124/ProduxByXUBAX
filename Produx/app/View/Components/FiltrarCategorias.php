<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FiltrarCategorias extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $rows;
    public $titulo;
    public $id;
    public function __construct($titulo, $rows, $id)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->rows = $rows;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.filtrar-categorias');
    }
}
