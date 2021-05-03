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
    public function __construct($titulo ,$rows)
    {
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
        return view('components.filtro-analiticos');
    }
}
