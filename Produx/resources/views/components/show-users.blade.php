<tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nombre</span>
        {{$name}}
    </td>
    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Correo electronico</span>
        {{$email}}
    </td>
    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Equipo</span>
        @foreach($teams as $team)
            @if(!empty($team))
        <span class="rounded bg-green-400 py-1 px-3 text-xs font-bold">{{$team->name}}</span>
            @endif
        @endforeach
    </td>
    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Rol</span>
        
            @if(!empty($rol))
                @switch($rol)
                    @case("Owner")
                        <span class="rounded bg-blue-400 py-1 px-3 text-xs font-bold">{{'Propietario'}}</span>
                        @break
                    
                    @case("Editor")
                        <span class="rounded bg-purple-400 py-1 px-3 text-xs font-bold">{{$rol}}</span>
                        @break
                    
                    @case("Administrador")
                        <span class="rounded bg-green-400 py-1 px-3 text-xs font-bold">{{$rol}}</span>
                        @break
                    
                    @case("Monitorista")
                        <span class="rounded bg-pink-400 py-1 px-3 text-xs font-bold">{{$rol}}</span>
                        @break
                    @default
                        <span class="rounded bg-yellow-400 py-1 px-3 text-xs font-bold">{{$rol}}</span>
                @endswitch
                
            @endif
    </td>
    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Acciones</span>
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-1 sm:col-span-2 md:col-span-1 lg:col-span-1 xl:col-span-1...">
                @if($update == True)
                    {{-- <form action="" method="POST"> --}}
                        <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg></button>
                    {{-- </form> --}}
               @endif
            </div>
            <div class="col-span-1 sm:col-span-2 md:col-span-1 lg:col-span-1 xl:col-span-1...">
                @if($delete == True)
                    <form action="{{ route('users.destroy',$id)}}" method="POST" accept-charset="utf-8" style="width: auto">
                        @method('DELETE')
                        @csrf
                        <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg></button>
                    </form>
                @endif
            </div>
        </div>
        
        
    </td>
</tr>