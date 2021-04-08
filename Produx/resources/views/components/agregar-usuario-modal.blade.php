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
                Agregar usuario
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
            <h2 class="font-semibold text-2xl">Invitar miembro al grupo</h2>
          </header>
          <form action="" method="POST">
            @csrf
            @method('POST')
          </form>
            <main class="p-3 text-center">
              <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="email" value="{{ __('Correo electronico') }}" />
                <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="addTeamMemberForm.email" />
                <x-jet-input-error for="email" class="mt-2" />
            </div>
            @php
                $addTeamMemberForm = null;
            @endphp
            <div class="col-span-6 lg:col-span-4">
              <x-jet-label for="role" value="{{ __('Rol') }}" />
              <x-jet-input-error for="role" class="mt-2" />
              <script>
              </script>
              <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                  @foreach ($roles as $role)
              
                      <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-green-700 focus:shadow-outline-blue border-t border-l border-r border-b border-gray-200 rounded-t-none"
                                      wire:click="">
                          <div class="">
                              <!-- Role Name -->
                              <div class="flex items-center">
                                  <div class="text-sm text-gray-700 ">
                                      {{ $role->name }}
                                  </div>

                                  
                                      <svg id="{{$role->key}}" hidden="true" class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                              </div>

                              <!-- Role Description -->
                              <div class="flex items-center">
                                <div class="mt-0 text-xs text-gray-600">
                                    {{ $role->description }}
                                </div>
                              </div>
                          </div>
                      </button>
                  @endforeach
              </div>
          </div>
            </main>
            <input type="text" name="" value="{{route('Devices.store')}}" id="route" hidden="">
          <footer class="flex justify-center bg-blue-600">
            <button type="submit"  onclick="" 
              class="bg-blue-600 font-semibold text-white py-3 w-full rounded-b-md hover:bg-blue-700 focus:outline-none focus:ring shadow-lg hover:shadow-none transition-all duration-300"
              @click="showModal2 = false">
              Guardar
            </button>
            <button type="" 
              class="bg-red-700 font-semibold text-white py-3 w-full rounded-b-md hover:bg-red-600 focus:outline-none focus:ring shadow-lg hover:shadow-none transition-all duration-300"
              @click="showModal2 = false">
              Cancelar
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
