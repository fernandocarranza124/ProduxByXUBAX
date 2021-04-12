<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GeneralDashboard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $acciones;
    public $dispositivos;
    public function __construct($dispositivos ,$acciones)
    {
        
        $this->dispositivos = $dispositivos;
        $this->acciones = $acciones;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.general-dashboard');
    }
}
