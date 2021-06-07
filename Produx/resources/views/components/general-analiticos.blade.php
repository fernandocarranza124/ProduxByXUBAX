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
<div>
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  <div class="flex px-4">
	  <!--actual component start-->
	  <div x-data="setup()">
		  <ul class="flex">
			  <template x-for="(tab, index) in tabs" :key="index">
				  <li class="cursor-pointer py-2 px-4 text-gray-500 border-b-8"
					  :class="activeTab===index ? 'text-red-500 border-red-500' : ''" @click="activeTab = index"
					  x-text="tab"></li>
			  </template>
		  </ul>
		  <div class="w-auto bg-white text-center">
			  <div x-show="activeTab===0">
          <section class="flex flex-row flex-wrap mx-auto" id="analiticos">
            <x-cards-info-analiticos titulo="Productos totales" icono="chip" :valor="$infos->productosTotales" extra="" color="" />    
            <x-cards-info-analiticos titulo="Productos con interaccion" icono="chip" :valor="$infos->productosConInteraccion" extra="" color="" />    
            <x-cards-info-analiticos titulo="Porcentaje de interacciones" icono="stick" :valor="$infos->porcentajeInteracciones" extra="%" color="true" />    
            <x-cards-info-analiticos titulo="Tiempo en anaquel" icono="clock" :valor="$infos->tiempoEnAnaquel" extra="segundos" color="" />    
            <x-cards-info-analiticos titulo="Tiempo en mano" icono="clock" :valor="$infos->tiempoEnMano" extra="segundos" color="" />    
            <x-cards-info-analiticos titulo="Porcentaje de tiempo" icono="stick" :valor="$infos->porcentajeDeTiempo" extra="%" color="true" />    
          </section>
          <section class="flex flex-row flex-wrap mx-auto">
            <x-chart-info-analiticos id="Productos con mas interacciones" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="TopMasInteracciones" titulo="5 productos con mayor interaccion" tooltip="productos con mayor número de interacciones" />    
            <x-chart-info-analiticos id="ProductosInteraccionesDiasDeLaSemana" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="ProductosInteraccionesDiasDeLaSemana" titulo="Interacciones durante los dias de la semana" tooltip="Interacciones de los dipositivos en cada dia de la semana" />    
            <x-chart-info-analiticos id="ProductosInteraccionesHorasAlDia" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="ProductosInteraccionesHorasAlDia" titulo="Interacciones durante las horas del dia" tooltip="Interacciones de los dipositivos en cada hora del día" />
            <x-chart-info-analiticos id="levantamientos" tipoDeGrafica="PieChart" nombreDeGraficaLava="levantamientosVSReposo" titulo="Tiempo de productos en mano y en anaquel" tooltip="Tiempo en mano y en anaquel de los dispositivos" />
            <x-chart-info-analiticos id="TiemposDiasDeLaSemana" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="TiemposDiasDeLaSemana" titulo="Minutos de interacción durante la semana" tooltip="Tiempo de interacciones de los dipositivos en cada dia de la semana" />
            <x-chart-info-analiticos id="TiemposInteraccionesHorasAlDia" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="TiemposInteraccionesHorasAlDia" titulo="Minutos de interacción durante las horas del dia" tooltip="Segundos de interacciones de los dipositivos durante las horas del dia" />
            {{-- TiemposInteraccionesHorasAlDia --}}
          </section>
          <section class="flex flex-row flex-wrap mx-auto" id="seemetrix">
            <x-cards-info-analiticos titulo="Oportunidades de imapcto" icono="people" :valor="$seemetrix[0]->data->ots" extra="" color="" />    
            <x-cards-info-analiticos titulo="Total de impactos generados" icono="eye" :valor="$seemetrix[0]->data->v" extra="" color="" />    
              @php
              $porcentajeInteracciones = number_format(($seemetrix[0]->data->v)/($seemetrix[0]->data->ots)*100, 2);
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
            <x-chart-info-analiticos id="Cantidades de ODI - Impactos" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Cantidades de ODI - Impactos" titulo="Comparación de ODI - Impactos" tooltip="Oportunidades de impacto - Impactos" />
            <x-chart-info-analiticos id="Cantidades de impactos por Dia" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Cantidades de impactos por Dia" titulo="Comparación de ODP - Impactos por dia" tooltip="Oportunidades de impacto - Impactos" />
            <x-chart-info-analiticos id="Cantidad de impactos por hora" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Cantidad de impactos por hora" titulo="Comparación de ODI - Impactos por hora" tooltip="Oportunidades de impacto - Impactos" />
            <x-chart-info-analiticos id="Tiempo de atencion ODI - Impactos" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Tiempo de atencion ODI - Impactos" titulo="Tiempo de atenciom ODI - Impactos" tooltip="Oportunidades de impacto - Impactos" />
            <x-chart-info-analiticos id="Tiempo de impactos por dia de la semana" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Tiempo de impactos por dia de la semana" titulo="Tiempo de impactos por dia de la semana" tooltip="Oportunidades de impacto - Impactos" />
            <x-chart-info-analiticos id="Duracion de impactos por hora" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Duracion de impactos por hora" titulo="Duracion de impactos por hora" tooltip="Oportunidades de impacto - Impactos" />
          </section>
        </div>
			  <div x-show="activeTab===1">
          <section class="flex flex-row flex-wrap mx-auto" id="Demograficos">
            <x-cards-info-analiticos titulo="Hombres" icono="chip" :valor="$infos->productosTotales" extra="" color="" />    
            <x-cards-info-analiticos titulo="Mujeres" icono="chip" :valor="$infos->productosConInteraccion" extra="" color="" />    
            <x-cards-info-analiticos titulo="Top rango de edad" icono="stick" :valor="$infos->porcentajeInteracciones" extra="%" color="true" />    
            <x-cards-info-analiticos titulo="Atencion de los hombres" icono="clock" :valor="$infos->tiempoEnAnaquel" extra="segundos" color="" />    
            <x-cards-info-analiticos titulo="Atencion de las mujeres" icono="clock" :valor="$infos->tiempoEnMano" extra="segundos" color="" />    
            <x-cards-info-analiticos titulo="Mayor tiempo de atención" icono="stick" :valor="$infos->porcentajeDeTiempo" extra="%" color="true" />    
          </section>
        </div>
			  <div x-show="activeTab===2">
          Content 3
        </div>
			  <div x-show="activeTab===3">
          Content 4
        </div>
		  </div>
	  </div>
	  <!--actual component end-->
  </div>
  <script>
	  function setup() {
      return {
        activeTab: 0,
        tabs: [
          "General",
          "Demograficos",
          "Dispositivos",
          "Entorno",
        ]
      };
    };
  </script>  
</div>  

