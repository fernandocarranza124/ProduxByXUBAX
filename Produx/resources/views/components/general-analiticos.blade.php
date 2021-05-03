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
    
    
    
    
    {{-- <x-filtro-analiticos titulo="Fecha final"  /> --}}
    {{-- <x-opciones-filtro-analiticos titulo="Categoria"  /> --}}
    <div class="pt-2 relative mx-auto text-gray-600">
      Categorias: 
      <x-filtro-analiticos titulo="Categorias" :rows="$categorias" />
      {{-- <x-filtro-analiticos titulo="Dispositivos" :rows="$dispositivos" /> --}}
      {{-- Categorias
    <select class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
      type="search" name="search" placeholder="Categorias">
      <option value="s"></option>
    </select>
    
  </div>
  <div class="pt-2 relative mx-auto text-gray-600">
    Dispositivos
  <select class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
    type="search" name="search" placeholder="Dispositivos">
    <option value="s"></option>
  </select> --}}
  
</div>

  <div class="pt-2 relative mx-auto text-gray-600">
    Etiquetas: <br>
    <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
      type="search" name="search" placeholder="Etiquetas">
    <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
      <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
        viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
        width="512px" height="512px">
        <path
          d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
      </svg>
    </button>
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