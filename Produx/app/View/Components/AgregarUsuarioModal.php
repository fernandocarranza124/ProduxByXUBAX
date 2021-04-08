<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AgregarUsuarioModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $team;
    public $roles;
    public function __construct($team, $roles)
    {
        $this->team = $team;
        $this->roles = $roles;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.agregar-usuario-modal');
    }
}
