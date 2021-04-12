<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EditarDeviceModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $nombre;
    public $teams;
    public $users;
    // public $ownerId;
    public $id;
    public $allTags;
    public $categorias;
    public function __construct($id, $nombre, $allTags, $teams, $users, $categorias)
    {   
        $this->id = $id;
        // $this->ownerId = $ownerId;
        $this->teams = $teams;
        $this->users = $users;
        $this->nombre = $nombre;
        $this->allTags = $allTags;
        $this->categorias = $categorias;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.editar-device-modal');
    }
}
