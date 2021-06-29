<div class="transition-all duration-150 flex w-full px-2 py-6 md:w-1/1 lg:w-{{$width}} h-1/3 ">
    <div class="flex flex-col items-stretch min-h-full pb-4 mb-6 transition-all duration-150 bg-white rounded-lg shadow-lg hover:shadow-2xl w-full" >
    <hr class="border-gray-300" />
    <div class="flex items-center text-center">
      {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
      </svg> --}}
      {!! $icono !!}
      
        <div class="ml-4 text-md text-center text-gray-600 leading-7 font-semibold">
          <div class="tooltip">
            <p class="text-center">{{$titulo}}</p>
          <span class="tooltiptext text-gray-500"><small>{{$tooltip}}</small></span>  
          </div>
          
        </div>
    </div>
    <hr class="border-gray-300" />
    <div class="row">
        <div id="{{$divId}}"></div>
   </div> 
      {{-- <hr class="border-gray-300" /> --}}
    </div>
  </div>
{{-- Recibir id, tipo de grafica, nombre de la grafica en lava y titulo --}}

<?= Lava::render($tipoDeGrafica, $nombreDeGraficaLava, $divId) ?>   