<meta name="csrf-token" content="{{ csrf_token() }}" />
<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <div x-data="{ showModal2: false }" :class="{'overflow-y-hidden':showModal2}">
    
    <div class="">
            <button type="submit" @click="showModal2 = true"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
            </svg></button>
        <div class="lg:col-span-2 md:col-span-0 xs:col-span-0 "></div>
        
@php
    // dd($nombre);
@endphp    
        
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
            <h2 class="font-semibold text-2xl">Modificar dispositivo</h2>
          </header>
          <form action="{{route('Devices.update', $id)}}" method="POST" accept-charset="utf-8" style="width: auto">
          <main class="p-3 text-center">
              @php
                //   dd(URL::route('Categorias.update',$id));
              @endphp
            
                @method('PUT')
                @csrf
                <div class="grid lg:grid-cols-1 gap-6">
                  {{-- <form action="{{route('Categorias.store')}}" method="post" accept-charset="utf-8"> --}}
              
                    {{-- Campo Nombre --}}
                    <div class="border focus-within:border-blue-500 focus-within:text-blue-500 transition-all duration-500 relative rounded p-1">
                    
                      <div class="-mt-4 absolute tracking-wider px-1 uppercase text-xs">
                        <p>
                        <label for="nameDevice" class="bg-white text-gray-600 px-1"> Nombre del dispositivo</label>
                        </p>
                      </div>
                        <p>
                          <input id="nameDevice" name="nameDevice" autocomplete="false" tabindex="0" type="text" class="py-1 px-1 text-gray-900 outline-none block h-full w-full" value="{{$nombre}}">
                        </p>
                    </div>
                    <br>
                    {{-- Campo Grupo --}}
                    <div class="border focus-within:border-blue-500 focus-within:text-blue-500 transition-all duration-500 relative rounded p-1">
                        
                        <div class="-mt-4 absolute tracking-wider px-1 uppercase text-xs">
                          <p>
                            <label for="idCategoria" class="bg-white text-gray-600 px-1"> Pertenece a la categoria</label>
                          </p>
                        </div>
                        <p>
                          {{-- <input id="idGrupo" name="idGrupo" autocomplete="false" tabindex="0" type="text" class="py-1 px-1 text-gray-900 outline-none block h-full w-full"> --}}
                          <select name="idCategoria" id="idCategoria" class="py-1 px-1 text-gray-900 outline-none block h-full w-full">
                              @foreach ($categorias as $categoria)
                                <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                              @endforeach
                          </select>
                        </p>
                      </div>
                      <br>
                      {{-- Agregar etiquetas --}}
                      <div class="border focus-within:border-blue-500 focus-within:text-blue-500 transition-all duration-500 relative rounded p-1">
                    
                        <div class="-mt-4 absolute tracking-wider px-1 uppercase text-xs">
                          <p>
                          <label for="addEtiquetas" class="bg-white text-gray-600 px-1"> Agregar etiqueta</label>
                          </p>
                        </div>
                          <p>
                            <input id="addEtiquetas" name="addEtiquetas" autocomplete="false" tabindex="0" type="text" class="py-1 px-1 text-gray-900 outline-none block h-full w-full" placeholder="Escribe las etiquetas separadas por comas">
                          </p>
                      </div>
                      <br>
                      {{--  --}}
                      <div class="border focus-within:border-blue-500 focus-within:text-blue-500 transition-all duration-500 relative rounded p-1">
                        <div class="-mt-4 absolute tracking-wider px-1 uppercase text-xs">
                          <p>
                            <label for="idGrupo" class="bg-white text-gray-600 px-1"> Tiene las etiquetas</label>
                          </p>
                        </div>
                          @foreach ($allTags as $tag)
                                  <div style="display:none">
                                                <label class="inline-flex items-center">
                                                  <span class="rounded bg-{{$tag->color}} py-1 px-3 text-xs font-bold">
                                                  <input type="checkbox" class="form-checkbox inline-block" name="etiquetas[]" value="{{$tag->id}}" id="{{$tag->id}}-{{$tag->nombre}}" checked="true">
                                                        {{$tag->nombre}}
                                                  </span>
                                                </label>
                                  </div>
                                  <span class="rounded bg-{{$tag->color}} py-1 px-3 text-xs font-bold" id="tag-{{$tag->id}}-{{$tag->nombre}}">
                                    
                                      <svg  xmlns="http://www.w3.org/2000/svg" class="px-1 inline-block " width="24" height="24" viewBox="0 0 20 20" fill="currentColor" style="cursor: pointer;">
                                          <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                        {{$tag->nombre}}
                                        
                                          <svg xmlns="http://www.w3.org/2000/svg" class="px-1 inline-block close" width="24" height="24" viewBox="0 0 20 20" fill="currentColor" style="" onclick="unCheckInput('{{$tag->id}}-{{$tag->nombre}}')">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                          </svg>          
                                  </span>
                          @endforeach    
                          
                      </div>
                        <br>
                    </div>
                </main>
                <style>
                  .close {
                    cursor: pointer;
                  }
                  .close:hover {
                    color: #ccc;
                  }
                </style>
                <script>
                  function unCheckInput($id) {
                    $input = document.getElementById($id);
                    $input.checked=false;
                    $tag = document.getElementById("tag-"+$id);
                    $tag.style.display = "none";
                  }
                </script>
            <input type="text" name="" value="" id="route" hidden="">
            
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
        </form>
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
