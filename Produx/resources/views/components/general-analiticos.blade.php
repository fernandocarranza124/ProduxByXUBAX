<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    // Add smooth scrolling to all links
    
        // Store hash
        var hash = "#analiticos";
        // Using jQuery's animate() method to add smooth page scroll
        // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
        $('html, body').animate({
          scrollTop: $("#analiticos").offset().top
        }, 1200, function(){
     
          // Add hash (#) to URL when done scrolling (default click behavior)
          window.location.hash = hash;
        });
       // End if
    });
  
  </script>
  <section class="flex flex-row flex-wrap sm:mx-auto items-left" id="filtros">
    <form action="{{ route('Analiticos.filter')}}" method="GET" accept-charset="utf-8">
      
    <div class="pt-2 relative mx-auto text-gray-600 flex">
      
      @php
      
      
      
      @endphp
      {{-- @php
          dd($infos->fechaInicial);
      @endphp --}}
      <x-filtro-analiticos titulo="Fecha inicial" :rows="$categorias" id="fechaInicial" fechaActual="{{$infos->fechaInicial}}"/>
      <x-filtro-analiticos titulo="Fecha final" :rows="$categorias" id="fechaFinal"  fechaActual="{{$infos->fechaFinal}}"/>
      <x-filtrar-categorias titulo="Categorias" :rows="$categorias" id="categorias" />
    </div>
  <button type="submit">Filtrar</button>
</form>
  </section>
  <a href="#analiticos" ></a>
  
<section class="flex flex-row flex-wrap mx-auto" id="analiticos">
  
  {{-- @php
    dd($infos);  
  @endphp --}}
    <x-cards-info-analiticos titulo="Productos totales" icono="chip" :valor="$infos->productosTotales" extra="" color="" />    
    <x-cards-info-analiticos titulo="Productos con interaccion" icono="chip" :valor="$infos->productosConInteraccion" extra="" color="" />    
    <x-cards-info-analiticos titulo="Porcentaje de interacciones" icono="stick" :valor="$infos->porcentajeInteracciones" extra="%" color="true" />    
    <x-cards-info-analiticos titulo="Tiempo en anaquel" icono="clock" :valor="$infos->tiempoEnAnaquel" extra="segundos" color="" />    
    <x-cards-info-analiticos titulo="Tiempo en mano" icono="clock" :valor="$infos->tiempoEnMano" extra="segundos" color="" />    
    <x-cards-info-analiticos titulo="Porcentaje de tiempo" icono="stick" :valor="$infos->porcentajeDeTiempo" extra="%" color="true" />    
</section>

<section class="flex flex-row flex-wrap mx-auto">
    @php
        
    @endphp
    <x-chart-info-analiticos id="Productos con mas interacciones" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="TopMasInteracciones" titulo="5 productos con mayor interaccion" tooltip="productos con mayor número de interacciones" />    
    <x-chart-info-analiticos id="ProductosInteraccionesDiasDeLaSemana" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="ProductosInteraccionesDiasDeLaSemana" titulo="Interacciones durante los dias de la semana" tooltip="Interacciones de los dipositivos en cada dia de la semana" />    
    <x-chart-info-analiticos id="ProductosInteraccionesHorasAlDia" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="ProductosInteraccionesHorasAlDia" titulo="Interacciones durante las horas del dia" tooltip="Interacciones de los dipositivos en cada hora del día" />
    <x-chart-info-analiticos id="levantamientos" tipoDeGrafica="PieChart" nombreDeGraficaLava="levantamientosVSReposo" titulo="Tiempo de productos en mano y en anaquel" tooltip="Tiempo en mano y en anaquel de los dispositivos" />
    <x-chart-info-analiticos id="TiemposDiasDeLaSemana" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="TiemposDiasDeLaSemana" titulo="Minutos de interacción durante la semana" tooltip="Tiempo de interacciones de los dipositivos en cada dia de la semana" />
    <x-chart-info-analiticos id="TiemposInteraccionesHorasAlDia" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="TiemposInteraccionesHorasAlDia" titulo="Minutos de interacción durante las horas del dia" tooltip="Segundos de interacciones de los dipositivos durante las horas del dia" />
    {{-- TiemposInteraccionesHorasAlDia --}}
</section>
<section class="flex flex-row flex-wrap mx-auto" id="seemetrix">
  
  {{-- @php
    dd($infos);  
  @endphp --}}
  
    <x-cards-info-analiticos titulo="Oportunidades de imapcto" icono="people" :valor="$seemetrix[0]->data->ots" extra="" color="" />    
    <x-cards-info-analiticos titulo="Total de impactos generados" icono="eye" :valor="$seemetrix[0]->data->v" extra="" color="" />    
      @php
      $porcentajeInteracciones = number_format(($seemetrix[0]->data->v)/($seemetrix[0]->data->ots)*100, 2);
      @endphp
      @php
      $seemetrix[0]->data->vd = substr($seemetrix[0]->data->vd,0,-3);
      $seemetrix[0]->data->otsd = substr($seemetrix[0]->data->otsd,0,-3);
      $porcentajeAtencion = number_format(($seemetrix[0]->data->vd)/($seemetrix[0]->data->otsd)*100, 2);
      
      @endphp
    <x-cards-info-analiticos titulo="Porcentaje de impactos" icono="stick" :valor="$porcentajeInteracciones" extra="%" color="true" />    
    <x-cards-info-analiticos titulo="Tiempo de inactividad" icono="clock" :valor="$seemetrix[0]->data->otsd" extra="segundos" color="" />    
    <x-cards-info-analiticos titulo="Tiempo de atencion" icono="clock" :valor="$seemetrix[0]->data->vd" extra="segundos" color="" />    
      
    <x-cards-info-analiticos titulo="Porcentaje de atraccion" icono="stick" :valor="$infos->porcentajeDeTiempo" extra="%" color="true" />    
</section>

<section class="flex flex-row flex-wrap mx-auto">
    <x-chart-info-analiticos id="ODP - Impactos comparación" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="ODP - Impactos comparación" titulo="Comparación de ODP - Impactos" tooltip="Oportunidades de impacto - Impactos" />
    @php
        
    @endphp
    {{-- <x-chart-info-analiticos id="Productos con mas interacciones" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="TopMasInteracciones" titulo="5 productos con mayor interaccion" tooltip="productos con mayor número de interacciones" />    
    <x-chart-info-analiticos id="ProductosInteraccionesDiasDeLaSemana" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="ProductosInteraccionesDiasDeLaSemana" titulo="Interacciones durante los dias de la semana" tooltip="Interacciones de los dipositivos en cada dia de la semana" />    
    <x-chart-info-analiticos id="ProductosInteraccionesHorasAlDia" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="ProductosInteraccionesHorasAlDia" titulo="Interacciones durante las horas del dia" tooltip="Interacciones de los dipositivos en cada hora del día" />
    <x-chart-info-analiticos id="levantamientos" tipoDeGrafica="PieChart" nombreDeGraficaLava="levantamientosVSReposo" titulo="Tiempo de productos en mano y en anaquel" tooltip="Tiempo en mano y en anaquel de los dispositivos" />
    <x-chart-info-analiticos id="TiemposDiasDeLaSemana" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="TiemposDiasDeLaSemana" titulo="Minutos de interacción durante la semana" tooltip="Tiempo de interacciones de los dipositivos en cada dia de la semana" />
    <x-chart-info-analiticos id="TiemposInteraccionesHorasAlDia" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="TiemposInteraccionesHorasAlDia" titulo="Minutos de interacción durante las horas del dia" tooltip="Segundos de interacciones de los dipositivos durante las horas del dia" /> --}}
    {{-- TiemposInteraccionesHorasAlDia --}}
</section>

<style>
  <style>
/* Tooltip container */
.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
}

/* Tooltip text */
.tooltip .tooltiptext {
  visibility: hidden;
  width: 14rem;
  background-color: black;
  color: #fff;
  text-align: center;
  padding: 5px 0;
  border-radius: 6px;
 
  /* Position the tooltip text - see examples below! */
  position: absolute;
  z-index: 1;
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltip:hover .tooltiptext {
  visibility: visible;
}
</style>