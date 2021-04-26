<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardsInfoAnaliticos extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $titulo;
    public $icono;
    public $valor;
    public $extra;
    public $color;
    public function __construct( $titulo, $icono, $valor, $extra, $color )
    {
        $this->titulo = $titulo;
        $this->icono = $icono;
        $this->valor = $valor;
        $this->color = $color;
        $this->extra = $extra;
        if($extra == "minutos" && $valor > 100 ){
            // Se transforma a horas
            $valor = (int)$valor / 60;
            
            $this->valor = number_format((float)$valor, 2, '.', '');
            $this->extra = "horas";
            
            if($valor > 100 ){
                // Se transforma a dias
                $valor = (int)($valor / 24);
                $this->valor = $valor;
                $this->extra = "dias";
            }
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cards-info-analiticos');
    }
}
