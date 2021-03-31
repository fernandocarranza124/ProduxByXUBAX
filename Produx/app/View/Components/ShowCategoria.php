<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ShowCategoria extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $nombre;
    public $id;
    public $team_id;
    public $team;
    public $owner_id;
    public $owner;
    public function __construct($categoria)
    {
        $this->nombre = $categoria->nombre;
        $this->id = $categoria->id;
        $this->team_id = $categoria->team_id;
        $this->team = $categoria->team;
        $this->owner_id = $categoria->owner_id;
        $this->owner = $categoria->owner;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.show-categoria');
    }
}
