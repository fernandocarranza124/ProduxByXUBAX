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
    <x-chart-info-analiticos id="Productos con mas interacciones" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="TopMasInteracciones" titulo="5 productos con mayor interaccion" />    
    <x-chart-info-analiticos id="ProductosInteraccionesDiasDeLaSemana" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="ProductosInteraccionesDiasDeLaSemana" titulo="Interacciones durante los dias de la semana" />    
    <x-chart-info-analiticos id="ProductosInteraccionesHorasAlDia" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="ProductosInteraccionesHorasAlDia" titulo="Interacciones durante las horas del dia" />    
    <x-chart-info-analiticos id="levantamientos" tipoDeGrafica="PieChart" nombreDeGraficaLava="levantamientosVSReposo" titulo="levantamientosVSReposo" />    
    <x-chart-info-analiticos id="TiemposDiasDeLaSemana" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="TiemposDiasDeLaSemana" titulo="Minutos de interacción durante la semana" />    
    
    {{--  --}}
</section>