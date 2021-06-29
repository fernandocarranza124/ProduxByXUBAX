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
    // dd($seemetrix);
      
      
      @endphp
      @php
          
      @endphp
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
            <x-chart-info-analiticos id="TiemposDiasDeLaSemana" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="TiemposDiasDeLaSemana" titulo="Minutos de interacción durante la semana" tooltip="Interacciones de los dipositivos durante la semana" />
            <x-chart-info-analiticos id="TiemposInteraccionesHorasAlDia" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="TiemposInteraccionesHorasAlDia" titulo="Minutos de interacción durante el dia" tooltip="Interacciones de los dipositivos durante el dia" />
            {{-- TiemposInteraccionesHorasAlDia --}}
          </section>
          
        </div>
			  <div x-show="activeTab===1">
          <section class="flex flex-row flex-wrap mx-auto" id="seemetrix">
            <x-cards-info-analiticos titulo="ODI" icono="people" :valor="$seemetrix[0]->data->ots" extra="" color="" />    
            <x-cards-info-analiticos titulo="Impactos" icono="eye" :valor="$seemetrix[0]->data->v" extra="" color="" />    
              @php
              $porcentajeInteracciones = number_format(($seemetrix[0]->data->v)/($seemetrix[0]->data->ots)*100, 2);
              $seemetrix[0]->data->vd = substr($seemetrix[0]->data->vd,0,-3);
              $seemetrix[0]->data->otsd = substr($seemetrix[0]->data->otsd,0,-3);
              $porcentajeAtencion = number_format(($seemetrix[0]->data->vd)/($seemetrix[0]->data->otsd)*100, 2);
              @endphp
            <x-cards-info-analiticos titulo="Conversión de impactos" icono="stick" :valor="$porcentajeInteracciones" extra="%" color="true" />    
            <x-cards-info-analiticos titulo="Tiempo de inactividad" icono="clock" :valor="$seemetrix[0]->data->otsd" extra="segundos" color="" />    
            <x-cards-info-analiticos titulo="Tiempo de atención" icono="clock" :valor="$seemetrix[0]->data->vd" extra="segundos" color="" />      
            <x-cards-info-analiticos titulo="Conversión de atracción" icono="stick" :valor="$infos->porcentajeDeTiempo" extra="%" color="true" />    
          </section>
          <section class="flex flex-row flex-wrap mx-auto">
            <x-chart-info-analiticos id="Cantidades de ODI - Impactos" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Cantidades de ODI - Impactos" titulo="Comparación de ODI - Impactos" tooltip="ODI - Impactos general" />
            <x-chart-info-analiticos id="Cantidades de impactos por Dia" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Cantidades de impactos por Dia" titulo="Comparación de ODI - Impactos por dia" tooltip="ODI - Impactos semanal" />
            <x-chart-info-analiticos id="Cantidad de impactos por hora" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Cantidad de impactos por hora" titulo="Comparación de ODI - Impactos por hora" tooltip="ODI - Impactos diario" />
            <x-chart-info-analiticos id="Tiempo de atencion ODI - Impactos" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Tiempo de atencion ODI - Impactos" titulo="Tiempo de atención ODI - Impactos" tooltip="ODI - Impactos general" />
            <x-chart-info-analiticos id="Tiempo de impactos por dia de la semana" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Tiempo de impactos por dia de la semana" titulo="Tiempo de impactos por dia de la semana" tooltip="Segundos de ODI - Impactos semanal " />
            <x-chart-info-analiticos id="Duracion de impactos por hora" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Duracion de impactos por hora" titulo="Duración de impactos por hora" tooltip="Segundos de ODI  - Impactos diario" />
            
          </section>
        </div>
			  <div x-show="activeTab===2">
          <section class="flex flex-row flex-wrap mx-auto" id="Demograficos">
            <x-cards-info-analiticos titulo="Hombres" icono="people" :valor="$seemetrix->cards->maleViews" extra="%" color="true" />    
            <x-cards-info-analiticos titulo="Mujeres" icono="people" :valor="$seemetrix->cards->femaleViews" extra="%" color="true" />    
            <x-cards-info-analiticos titulo="Top atención" icono="stick" :valor="$seemetrix->cards->topDemograficGroup" extra="%" color="true" />    
            <x-cards-info-analiticos titulo="Promedio atención hombre" icono="eye" :valor="$seemetrix->cards->maleAverageAttention" extra="segundos" color="" />    
            <x-cards-info-analiticos titulo="Promedio atención mujeres" icono="eye" :valor="$seemetrix->cards->femaleAverageAttention" extra="segundos" color="" />    
            <x-cards-info-analiticos titulo="Top tiempo" icono="stick" :valor="$seemetrix->cards->topAttentionTime" extra="segundos" color="" />    
          </section>
          <section class="flex flex-row flex-wrap mx-auto" id="demograficChart">
            <x-chart-info-analiticos id="Comparacion de edades por género" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Comparacion de edades por género" titulo="Comparación de edades por género" tooltip="Impactos entre hombres y mujeres" />
            <x-chart-info-analiticos id="Comparacion de impactos por género" tipoDeGrafica="DonutChart" nombreDeGraficaLava="Comparacion de impactos por género" titulo="Comparación de impactos por género" tooltip="Impactos entre hombres y mujeres" />
            <x-chart-info-analiticos id="Comparacion de impactos por edad" tipoDeGrafica="DonutChart" nombreDeGraficaLava="Comparacion de impactos por edad" titulo="Comparación de impactos por edad" tooltip="Impactos por edaes" />
            
            <x-chart-info-analiticos id="DemograficosImpactosPorSemana" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="DemograficosImpactosPorSemana" titulo="Impactos durante la semana" tooltip="Impactos por edades y genero durante la semana" width="1/2" />
            <x-chart-info-analiticos id="ImpactosInteraccionesHorasAlDia" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="ImpactosInteraccionesHorasAlDia" titulo="Impactos durante el dia" tooltip="" width="1/2" />
            <x-chart-info-analiticos id="DuracionDemograficosImpactosPorSemana" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="DuracionDemograficosImpactosPorSemana" titulo="Duración semanal de los impactos " tooltip="" width="1/2" />
            <x-chart-info-analiticos id="DuracionImpactosInteraccionesHorasAlDia" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="DuracionImpactosInteraccionesHorasAlDia" titulo="Duración diaria de los impactos" tooltip="" width="1/2" />

            <x-chart-info-analiticos id="Emociones" tipoDeGrafica="DonutChart" nombreDeGraficaLava="Emociones" titulo="Emociones gener" tooltip="" />
            <x-chart-info-analiticos id="Emociones por genero" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Emociones por genero" titulo="Emociones por genero" tooltip="" />
            <x-chart-info-analiticos id="Emociones por edad" tipoDeGrafica="ColumnChart" nombreDeGraficaLava="Emociones por edad" titulo="Emociones por edad" tooltip="" />
          </section>
        </div>
			  <div x-show="activeTab===3">
          En desarrollo
        </div>
        <div x-show="activeTab===4">
          En desarrollo
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
          "Impactos",
          "Demográficos",
          "Dispositivos",
          "Entorno",
        ]
      };
    };
  </script>  
</div>  
