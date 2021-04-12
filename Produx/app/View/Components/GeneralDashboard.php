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
    public $NumDispositivos;
    public function __construct($NumDispositivos)
    {
        $this->NumDispositivos = $NumDispositivos;
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
