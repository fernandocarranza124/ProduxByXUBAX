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
    public $rol;
    public $teams;
    public $delete=false;
    public $update=false;
    public function __construct($user)
    {
        $this->name=$user->name;
        $this->email=$user->email;
        $this->id=$user->id;
        $this->current_team_id=$user->current_team_id;
        $this->rol=$user->teamRole;
        $this->teams=$user->allTeams();
        // dd($user->update);
        if($user->update == True){
            $this->update=True;
        }
        if($user->delete == True){
            $this->delete=True;
        }
        if($this->rol=="Owner"){
            $this->delete=False;
        }
        
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
