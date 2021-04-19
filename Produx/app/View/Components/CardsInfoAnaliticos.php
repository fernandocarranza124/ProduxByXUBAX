<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardsInfoAnaliticos extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $titulo;
    public $icono;
    public function __construct( $titulo, $icono )
    {
        $this->titulo = $titulo;
        $this->icono = $icono;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cards-info-analiticos');
    }
}
