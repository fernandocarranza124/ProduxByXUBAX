<meta name="csrf-token" content="{{ csrf_token() }}" />
<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <div x-data="{ showModal1: false, showModal2: false, showModal3: false }" :class="{'overflow-y-hidden': showModal1 || showModal2 || showModal3}">
    
    <div class="grid grid-cols-3">
        <div class="lg:col-span-1 md:col-span-3 xs:col-span-3 ">
            <button
                class="bg-blue-700 font-semibold text-white p-2 w-80 rounded-full hover:bg-blue-400 focus:outline-none focus:ring shadow-lg hover:shadow-none transition-all duration-300 m-2 align-items: flex-end;" 
                @click="showModal2 = true">
                Agregar etiqueta
            </button>
        </div>
        <div class="lg:col-span-2 md:col-span-0 xs:col-span-0 "></div>
        
    
        
    </div>
      <div
          class="fixed inset-0 w-full h-full z-20 bg-black bg-opacity-50 duration-300 overflow-y-auto"
          x-show="showModal2"
          x-transition:enter="transition duration-300"
          x-transition:enter-start="opacity-0"
          x-transition:enter-end="opacity-100"
          x-transition:leave="transition duration-300"
          x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"
        >
      <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3 mx-2 sm:mx-auto my-10 opacity-100">
        <div
          class="relative bg-white shadow-lg rounded-lg text-gray-900 z-20"
          @click.away="showModal2 = false"
          x-show="showModal2"
          x-transition:enter="transition transform duration-300"
          x-transition:enter-start="scale-0"
          x-transition:enter-end="scale-100"
          x-transition:leave="transition transform duration-300"
          x-transition:leave-start="scale-100"
          x-transition:leave-end="scale-0"
        >
          <header class="flex flex-col justify-center items-center p-3 text-blue-600">
            <h2 class="font-semibold text-2xl">Agregar etiqueta</h2>
          </header>
          <main class="p-3 text-center">
            <div class="grid lg:grid-cols-1 gap-6">
              <form action="{{route('Etiquetas.store')}}" method="post" accept-charset="utf-8">
              @csrf
              
                <div class="border focus-within:border-blue-500 focus-within:text-blue-500 transition-all duration-500 relative rounded p-1">
                  <div class="-mt-4 absolute tracking-wider px-1 uppercase text-xs">
                    <p>
                      <label for="nameEtiqueta" class="bg-white text-gray-600 px-1"> Nombre de la etiqueta</label>
                    </p>
                  </div>
                  <p>
                    <input id="nameEtiqueta" name="nameEtiqueta" autocomplete="false" tabindex="0" type="text" class="py-1 px-1 text-gray-900 outline-none block h-full w-full">
                  </p>
                </div>
                <br>
              </div>
            </main>
            <input type="text" name="" value="{{route('Etiquetas.store')}}" id="route" hidden="">
          <footer class="flex justify-center bg-transparent">
            {{-- <button onclick="agregarDispositivo()" 
              class="bg-blue-600 font-semibold text-white py-3 w-full rounded-b-md hover:bg-blue-700 focus:outline-none focus:ring shadow-lg hover:shadow-none transition-all duration-300"
              @click="showModal2 = false">
              Guardar
            </button> --}}
            <button type="submit" 
              class="bg-blue-600 font-semibold text-white py-3 w-full rounded-b-md hover:bg-blue-700 focus:outline-none focus:ring shadow-lg hover:shadow-none transition-all duration-300"
              @click="showModal2 = false">
              Guardar
            </button>
          </footer>
        </div>
      </div>
      </form>
    </div>
    </div>
    <script>
      function agregarDispositivo(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var Nombre = $('#name').val();
        var NombreAccion = $('#actionName').val();
        var Categoria = $('#categoria').val();
        var PIN = $('#PIN').val();  
        var Ruta = $('#route').val();  
        $.ajax({
        url: Ruta,
        type: 'post',
        data: {_token: CSRF_TOKEN,nombre: Nombre,nombreAccion: NombreAccion,categoria: Categoria, PIN: PIN},
        success: function(response){
          alert ($('#tableDevices').val());
        }
      });
      }
      


      

    </script>
