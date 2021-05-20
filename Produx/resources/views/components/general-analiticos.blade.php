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
  <section id="tabs">
    <ul class="flex justify-left items-left">
			<template x-for="(tab, index) in tabs" :key="index">
				<li class="cursor-pointer px-4 rounded transition"
					:class="activeTab===index ? 'bg-red-500 text-white' : ' text-gray-500'" @click="activeTab = index"
					x-text="tab"></li>
			</template>
		</ul>
    <div class="flex justify-left">
      <!--actual component start-->
      <div x-data="setup()">
        <ul class="flex justify-left items-center mx-4">
          <template x-for="(tab, index) in tabs" :key="index">
            <li class="cursor-pointer py-2 px-4 text-gray-500 border-b-8"
              :class="activeTab===index ? 'text-red-500 border-red-500' : ''" @click="activeTab = index"
              x-text="tab"></li>
          </template>
        </ul>
    
        <div class="bg-white">
          <div x-show="activeTab===0">
            <section class="flex flex-row flex-wrap mx-auto" id="analiticos" name="">
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

          </div>
          <div x-show="activeTab===1">Demograficos</div>
          <div x-show="activeTab===2">Prouductos</div>
          <div x-show="activeTab===3">Emociones</div>
        </div>
      </div>
      <!--actual component end-->
    </div>
  </section>
  



<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>



<script>
	function setup() {
    return {
      activeTab: 0,
      tabs: [
          "General",
          "Demograficos",
          "Productos",
          "Categorias",
      ]
    };
  };
</script>
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