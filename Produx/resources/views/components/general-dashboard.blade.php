<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    // Add smooth scrolling to all links
    
        // Store hash
        var hash = "#dashboard";
        // Using jQuery's animate() method to add smooth page scroll
        // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
        $('html, body').animate({
          scrollTop: $("#dashboard").offset().top
        }, 1200, function(){
     
          // Add hash (#) to URL when done scrolling (default click behavior)
          window.location.hash = hash;
        });
       // End if
    });
  
  </script>
<div id="dashboard">
	<div class="content-wrapper" id="content-wrapper" style="">


		<div class="bg-gray-50">
  <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:py-2 lg:px-8 lg:flex lg:items-center lg:justify-between">
    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
      <span class="block">Numero de productos</span>
      <span class="block text-indigo-600"></span>
    </h2>
    <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
      <div class="inline-flex rounded-md shadow">
        <a href="#dashboard" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-indigo-700">
          {{$dispositivos}}
        </a>
      </div>
    </div>
  </div>
</div>
  </div>
</div>
</div>


<div class="p-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-5 items-stretch" >
    <!--Card 1-->
    <div class=" sm:max-w-full md:max-w-1/4 sm:col-span-1 md:flex-auto sm:h-full lg:h-full md:h-full xl:h-full shadow-lg">
      <div class="border-r border-b border-l border-white lg:border-1-1 lg:border-t lg:border-white bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal shadow">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-md mb-4 text-center">
            <span>
            <svg xmlns="http://www.w3.org/2000/svg" class="px-1 py-5 inline-block" width="24" height="24" viewBox="0 0 20 20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
            </svg>
            <p> INTERACCIONES TOTALES</p>
          </span>
          </div>
          <p class="text-gray-700 text-2xl text-center"><strong>{{$acciones->accionesTotales}}</strong></p>
        </div>
      </div>
    </div>
    <!--Card 1-->
    <div class=" sm:max-w-full md:max-w-1/4 sm:col-span-1 md:flex-auto sm:h-full lg:h-full md:h-full xl:h-full shadow-lg">
      <div class="border-r border-b border-l border-white lg:border-1-1 lg:border-t lg:border-white bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-md mb-4 text-center">
            <p>
            <span>
            <svg xmlns="http://www.w3.org/2000/svg" class="px-1 inline-block" width="24" height="24" viewBox="0 0 20 20" fill="none" viewBox="0 0 24 26" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            INTERACCIONES DE LA ULTIMA HORA
          </span>
        </p>
          </div>
          <p class="text-gray-700 text-2xl text-center"><strong>{{$acciones->accionesPorHora}}</strong></p>
        </div>
      </div>
    </div>
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto sm:h-full lg:h-full md:h-full xl:h-full shadow-lg">
      <div class="border-r border-b border-l border-white lg:border-1-1 lg:border-t lg:border-white bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal sm:h-full lg:h-full md:h-full xl:h-full">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-md mb-4 text-center">INTERACCIONES DEL DÍA</div>
          <p class="text-gray-700 text-2xl text-center"><strong>{{$acciones->accionesPorDia}}</strong></p>
        </div>
      </div>
    </div>
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto sm:h-full lg:h-full md:h-full xl:h-full shadow-lg">
      <div class="border-r border-b border-l border-white lg:border-1-1 lg:border-t lg:border-white bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal sm:h-full lg:h-full md:h-full xl:h-full">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-md mb-4 text-center">
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" class="px-1 inline-block" width="24" height="24" viewBox="0 0 20 20" fill="none" viewBox="0 0 24 26" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              INTERACCIONES DEL MES
            </span>
          </div>
          <p class="text-gray-700 text-2xl text-center"><strong>{{$acciones->accionesPorMes}}</strong></p>
        </div>
      </div>
    </div>
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto shadow-lg">
      <div class="border-r border-b border-l border-white lg:border-1-1 lg:border-t lg:border-white bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal sm:h-full lg:h-full md:h-full xl:h-full">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-md mb-4 text-center">
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" class="px-1 inline-block" width="24" height="24" viewBox="0 0 20 20" fill="none" viewBox="0 0 24 26" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              TIEMPO PROMEDIO DE INTERACCIÓN
            </span>
          </div>
          <p class="text-gray-700 text-xl text-center"><strong> {{$acciones->tiempoPromedioInteraccion}}</strong></p>
        </div>
      </div>
    </div>
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto shadow-lg">
      <div class="border-r border-b border-l border-white lg:border-1-1 lg:border-t lg:border-white bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal sm:h-full lg:h-full md:h-full xl:h-full">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-md mb-4 text-center">
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" class="px-1 inline-block" width="24" height="24" viewBox="0 0 20 20" fill="none" viewBox="0 0 24 26" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              PRODUCTOS EN MANO
            </span>
          </div>
          <p class="text-gray-700 text-2xl text-center"><strong>{{$acciones->productosEnMano}}</strong></p>
        </div>
      </div>
    </div>
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto shadow-lg">
      <div class="border-r border-b border-l border-white lg:border-1-1 lg:border-t lg:border-white bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal sm:h-full lg:h-full md:h-full xl:h-full">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-md mb-4 text-center">
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" class="px-1 inline-block" width="24" height="24" viewBox="0 0 20 20" fill="none" viewBox="0 0 24 26" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              PRODUCTOS EN ANAQUEL
            </span>
          </div>
          <p class="text-gray-700 text-2xl nmi1 xl text-center"><strong>{{$acciones->productosEnAnaquel}}</strong></p>
        </div>
      </div>
    </div>
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto shadow-lg">
      <div class="border-r border-b border-l border-white lg:border-1-1 lg:border-t lg:border-white bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal sm:h-full lg:h-full md:h-full xl:h-full">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-md mb-4 text-center">PRODUCTOS VENDIDOS / ROBADOS</div>
          <p class="text-gray-700 text-2xl text-center"><strong>{{$acciones->productosRobados}}</strong></p>
        </div>
      </div>
    </div> 
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto shadow-lg">
      <div class="border-r border-b border-l border-white lg:border-1-1 lg:border-t lg:border-white bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal sm:h-full lg:h-full md:h-full xl:h-full">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-md mb-4 text-center">PRODUCTO CON MAYOR INTERACCION DURANTE EL DIA</div>
          <p class="text-gray-700 text-xl text-center"><strong>{{$acciones->productoMayorInteraccionDia->device}}</strong></p><br>
          @php
              if($acciones->productoMayorInteraccionDia->NumeroInteracciones == null){
                $extraText = "";
              }else {
                $extraText = " interacciones";
              }
          @endphp
          <p class="text-gray-700 text-xl text-center"><strong>{{$acciones->productoMayorInteraccionDia->NumeroInteracciones}} {{$extraText}}</strong></p>
        </div>
      </div>
    </div>
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto shadow-lg">
      <div class="border-r border-b border-l border-white lg:border-1-1 lg:border-t lg:border-white bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal sm:h-full lg:h-full md:h-full xl:h-full">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-md mb-4 text-center" >PRODUCTO CON MAYOR INTERACCION DURANTE EL MES</div>
          <p class="text-gray-700 text-xl text-center"><strong>{{$acciones->productoMayorInteraccionMes->device}}</strong></p><br>
          @php
              if($acciones->productoMayorInteraccionMes->NumeroInteracciones == null){
                $extraText = "";
              }else {
                $extraText = " interacciones";
              }
          @endphp
          <p class="text-gray-700 text-md text-center"><strong>{{$acciones->productoMayorInteraccionMes->NumeroInteracciones}} interacciones</strong></p>
        </div>
      </div>
    </div>
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto shadow-lg">
      <div class="border-r border-b border-l border-white lg:border-l-1 lg:border-t lg:border-white bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal sm:h-full lg:h-full md:h-full xl:h-full">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-md mb-4 text-center">TASA DE CONVERSION DEL DIA</div>
          @php
              if($acciones->porcentajeDia <= 30){
                $color = "red-600";
              }else if ($acciones->porcentajeDia <=60){
                $color = 'yellow-600';
              }else{
                $color = 'green-600';
              }
          @endphp
          <p class="text-{{$color}} text-2xl text-center"><strong> {{$acciones->porcentajeDia}}%</strong></p>
        </div>
      </div>
    </div>
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto shadow-lg">
      <div class="border border-white lg:border-l-1 lg:border-t lg:border-white bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal sm:h-full lg:h-full md:h-full xl:h-full">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-md mb-4 text-center">TASA DE CONVERSION DEL MES</div>
          @php
              if($acciones->porcentajeMes <= 30){
                $color = "red-600";
              }else if ($acciones->porcentajeMes <=60){
                $color = 'yellow-600';
              }else{
                $color = 'green-600';
              }
          @endphp
          <p class="text-{{$color}} text-2xl text-center"><strong>{{$acciones->porcentajeMes}}%</strong></p>
        </div>
      </div>
    </div>
    
  </div>
</div>  
</div>