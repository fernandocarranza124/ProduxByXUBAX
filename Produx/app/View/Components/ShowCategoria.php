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
    public $update;
    public $delete;
    public $teamRole;
    public $teams;
    public $users;
    public function __construct($categoria, $teams, $users)
    {
        
        $this->teams = $teams;
        $this->users = $users;
        $this->nombre = $categoria->nombre;
        $this->id = $categoria->id;
        $this->team_id = $categoria->team_id;
        $this->team = $categoria->teamName;
        $this->owner_id = $categoria->user_id;
        $this->owner = $categoria->ownerName;
        $this->update = $categoria->update;
        $this->delete = $categoria->delete;
        $this->teamRole = $categoria->teamRole;
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
