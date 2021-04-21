<section class="flex flex-row flex-wrap mx-auto">
    <x-cards-info-analiticos titulo="Productos totales" icono="chip" />    
    <x-cards-info-analiticos titulo="Productos con interaccion" icono="chip" />    
    <x-cards-info-analiticos titulo="Porcentaje de interacciones" icono="stick" />    
    <x-cards-info-analiticos titulo="Tiempo en anaquel" icono="clock" />    
    <x-cards-info-analiticos titulo="Tiempo en mano" icono="clock" />    
    <x-cards-info-analiticos titulo="Porcentaje de tiempo" icono="stick" />    
</section>

<section class="flex flex-row flex-wrap mx-auto">
    @php
        
    @endphp
    <x-chart-info-analiticos :year="$year" :user="$user" titulo="OTS_Watchers" />    
    <x-chart-info-analiticos :year="$year" :user="$user" titulo="OTS_Semanal" />    
    <div class="transition-all duration-150 flex w-full px-2 py-6 md:w-1/1 lg:w-1/3 h-1/3 ">
        <div class="flex flex-col items-stretch min-h-full pb-4 mb-6 transition-all duration-150 bg-white rounded-lg shadow-lg hover:shadow-2xl w-full" >
        <hr class="border-gray-300" />
        <div class="flex items-center text-center">
            <svg fill="true"  viewBox="0 0 21 21" class="w-8 h-8 text-gray-400">
                    <path d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /> 
            </svg>
            <div class="ml-4 text-sm text-gray-600 leading-7 font-semibold">VS</div>
        </div>
        <hr class="border-gray-300" />
        <div class="row">
            <div id="pop_div"></div>
       </div> 
          {{-- <hr class="border-gray-300" /> --}}
        </div>
      </div>
    

    <?= Lava::render('PieChart', 'levantamientosVSReposo', 'pop_div') ?>   
    {{-- <x-chart-info-analiticos :year="$year" :user="$user" titulo="OTS_diario" />     --}}
</section>