<div class="transition-all duration-150 flex w-full px-2 py-6 md:w-1/1 lg:w-1/3 h-1/3 ">
    <div class="flex flex-col items-stretch min-h-full pb-4 mb-6 transition-all duration-150 bg-white rounded-lg shadow-lg hover:shadow-2xl w-full" >
    <hr class="border-gray-300" />
    <div class="flex items-center text-center">
        <svg fill="true"  viewBox="0 0 21 21" class="w-8 h-8 text-gray-400">
                <path d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /> 
        </svg>
        <div class="ml-4 text-md text-center text-gray-600 leading-7 font-semibold"><p class="text-center">{{$titulo}}</p></div>
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