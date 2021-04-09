<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ShowEtiquetas extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $teams;
    public $team;
    public $users;
    public $nombre;
    public $id;
    public $user_id;
    public $color;
    public $team_id;
    public $update;
    public $delete;
    public $teamRole;
    public $user;
    public $owner_id;
    public $owner;
    
    public function __construct($etiqueta, $teams, $users, $team, $user)
    {
        $this->team = $team;
        $this->user = $user;
        $this->teams = $teams;
        $this->users = $users;
        $this->nombre = $etiqueta->nombre;
        $this->id = $etiqueta->id;
        $this->team_id = $etiqueta->team_id;
        $this->team = $etiqueta->teamName;
        $this->owner_id = $etiqueta->user_id;
        $this->owner = $etiqueta->ownerName;
        $this->update = $etiqueta->update;
        $this->delete = $etiqueta->delete;
        $this->teamRole = $etiqueta->teamRole;
        $this->color = $etiqueta->color;
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.show-etiquetas');
    }
}
