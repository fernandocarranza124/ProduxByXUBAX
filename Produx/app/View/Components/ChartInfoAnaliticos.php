<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ChartInfoAnaliticos extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    // {{-- Recibir id, tipo de grafica, nombre de la grafica en lava y titulo --}}
    public $divId;
    public $tipoDeGrafica; 
    public $nombreDeGraficaLava;
    public $titulo;
    public function __construct($id , $tipoDeGrafica, $nombreDeGraficaLava, $titulo)
    {
        $this->divId = $id;
        $this->tipoDeGrafica = $tipoDeGrafica;
        $this->nombreDeGraficaLava = $nombreDeGraficaLava;
        $this->titulo = $titulo;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.chart-info-analiticos');
    }
}
