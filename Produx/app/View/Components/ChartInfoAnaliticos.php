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
    public $icono;
    public $tooltip;
    public $width;
    public function __construct($id , $tipoDeGrafica, $nombreDeGraficaLava, $titulo, $tooltip, $width = "1/3")
    {
      $this->width = $width;
        $this->tooltip = $tooltip;
        $this->divId = $id;
        $this->tipoDeGrafica = $tipoDeGrafica;
        switch ($tipoDeGrafica) {
            case 'ColumnChart':
                $this->icono = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>';
                break;
            case 'PieChart':
                $this->icono = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
              </svg>';
                break;
                
            
            default:
                $this->icono = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>';
                break;
        }
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
