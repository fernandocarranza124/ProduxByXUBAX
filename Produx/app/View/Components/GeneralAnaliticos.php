<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GeneralAnaliticos extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    
    public $infos;
    public function __construct($infos)
    {
        $this->infos = $infos;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.general-analiticos');
    }
}
