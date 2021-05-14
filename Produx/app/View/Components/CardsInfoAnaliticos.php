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
        if($extra == "segundos" && $valor > 100 ){
            // Se transforma a minutos
            $valor = (int)($valor / 60);
            $this->valor = $valor;
            $this->extra = "minutos";
            // Se cambia a horas
            if ($valor > 60) {
                $agregar = ($this->valor %60)." minutos";
                $valor = (int)$valor / 60;
                $this->valor = ($valor%60);
                if($this->valor > 1){
                    $this->extra = "horas";
                }else{
                    $this->extra = "hora";
                }
                if($this->valor > 1){
                    $this->extra = $this->extra." ".$this->valor." minutos";
                }else{
                    $this->extra = $this->extra." ".$this->valor." minuto";
                }
                
                
            }   
                
            //     if ($valor > 24) {
            //         $valor = (int)$valor / 60;
            //         $this->valor = number_format((float)$valor, 2, '.', '');
            //         $this->extra = "horas";
            
            //     if($valor > 100 ){
            //         // Se transforma a dias
            //         $valor = (int)($valor / 24);
            //         $this->valor = $valor;
            //         $this->extra = "dias";
            // }
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
