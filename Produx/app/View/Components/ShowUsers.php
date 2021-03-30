<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ShowUsers extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $id;
    public $email;
    public $current_team_id;
    public $roles;
    public $teams;
    public function __construct($user)
    {
        $this->name=$user->name;
        $this->email=$user->email;
        $this->id=$user->id;
        $this->current_team_id=$user->current_team_id;
        $this->roles=$user->getRoleNames();
        $this->teams=$user->allTeams();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {   
        
        return view('components.show-users');
    }
}
