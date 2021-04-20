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
    public $year;
    public $user; 
    public $titulo;
    public function __construct($year, $user, $titulo)
    {
        $this->year = $year;
        $this->user = $user;
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
