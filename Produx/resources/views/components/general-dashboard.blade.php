<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    // Add smooth scrolling to all links
    $("a").on('click', function(event) {
  
      // Make sure this.hash has a value before overriding default behavior
      if (this.hash !== "") {
        // Prevent default anchor click behavior
        event.preventDefault();
  
        // Store hash
        var hash = this.hash;
  
        // Using jQuery's animate() method to add smooth page scroll
        // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
        $('html, body').animate({
          scrollTop: $(hash).offset().top
        }, 800, function(){
     
          // Add hash (#) to URL when done scrolling (default click behavior)
          window.location.hash = hash;
        });
      } // End if
    });
  });
  </script>
<div id="dashboard">
	<div class="content-wrapper" id="content-wrapper" style="">


		<div class="bg-gray-50">
  <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
      <span class="block">Numero de dispositivos</span>
      <span class="block text-indigo-600"></span>
    </h2>
    <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
      <div class="inline-flex rounded-md shadow">
        <a href="#dashboard" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
          {{$dispositivos}}
        </a>
      </div>
    </div>
  </div>
</div>

<div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-5 items-stretch" >
    <!--Card 1-->
    <div class=" md:col-span-3 lg:col-span-2 md:w-full  sm:max-w-full md:max-w-full md:flex-auto sm:h-full">
      <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-xl mb-4">TODAS LAS ACCIONES</div>
          <p class="text-gray-700 text-base">{{$acciones->accionesTotales}}</p>
        </div>
      </div>
    </div>
    <!--Card 1-->
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto">
      <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-xl mb-4">ACCIONES DURANTE ESTA HORA</div>
          <p class="text-gray-700 text-base">{{$acciones->accionesPorHora}}</p>
        </div>
      </div>
    </div>
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto">
      <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-xl mb-4">ACCIONES DURANTE ESTE DÍA</div>
          <p class="text-gray-700 text-base">{{$acciones->accionesPorDia}}</p>
        </div>
      </div>
    </div>
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto">
      <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-xl mb-4">ACCIONES DURANTE ESTE MES</div>
          <p class="text-gray-700 text-base">{{$acciones->accionesPorMes}}</p>
        </div>
      </div>
    </div>
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto">
      <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-xl mb-4">DISPOSITIVOS CONECTADOS</div>
          <p class="text-gray-700 text-base">N/A</p>
        </div>
      </div>
    </div>
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto">
      <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-xl mb-4">TODOS LOS DISPOSITIVOS</div>
          <p class="text-gray-700 text-base">{{$dispositivos}}</p>
        </div>
      </div>
    </div>
    <div class=" sm:max-w-full md:max-w-1/4 md:flex-auto">
      <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
        <div class="mb-8">
          <div class="text-gray-900 font-bold text-xl mb-4">PROMEDIO DE TIEMPO EN ACCIONES CONCLUIDAS</div>
          <p class="text-gray-700 text-base">N/A</p>
        </div>
      </div>
    </div>
    
  </div>
</div>


        
        
</div>