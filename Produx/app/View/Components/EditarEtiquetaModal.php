<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EditarEtiquetaModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $nombre;
    public $teams;
    public $users;
    public $ownerId;
    public $id;
    public function __construct($id, $nombre, $ownerId, $teams, $users)
    {   
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->teams = $teams;
        $this->users = $users;
        $this->nombre = $nombre;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.editar-etiqueta-modal');
    }
}
