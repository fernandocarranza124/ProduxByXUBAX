<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dispositivos') }}
        </h2>

    </x-slot>
    {{--             dd($user->hasTeamPermission($team, 'create-product'));
 --}}
    @if($user->hasTeamPermission($team, 'create-product'))
        <x-agregar-dispositivo-modal :categorias="$categorias" :etiquetas="$etiquetas" />
    @endif
    <div class="py-12" style="padding-top: 1rem;padding-left: 2rem;padding-right:2rem;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                <table class="border-collapse w-full">
                    <thead>
                        <tr>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Estado</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Nombre</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Categoria</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Accion</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableDevices">
                        @isset($dispositivosPropios)
                            @foreach($dispositivosPropios as $device)
                                <x-show-devices :device="$device"  />
                            @endforeach
                        @endisset
                        @isset($dispositivosDeUsuariosEnGrupo)
                            @foreach($dispositivosDeUsuariosEnGrupo as $device)
                                <x-show-devices :device="$device"  />
                            @endforeach
                        @endisset
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
