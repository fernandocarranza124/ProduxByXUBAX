<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Etiquetas') }}
        </h2>

    </x-slot>
    {{--             dd($user->hasTeamPermission($team, 'create-product'));
 --}}
    @if($user->hasTeamPermission($team, 'create-categoria'))
        <x-agregar-etiqueta-modal />
    @else 
        
    @endif
    <div class="py-12" style="padding-top: 1rem;padding-left: 2rem;padding-right:2rem;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                <table class="border-collapse w-full">
                    <thead>
                        <tr>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Nombre</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Grupo</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Creador</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableCategorias">
                        @isset($etiquetas)
                            @foreach($etiquetas as $etiqueta)
                                @if(auth()->user()->hasTeamPermission($team, 'update-categoria'))
                                    {{-- Puede editar --}}
                                    @php 
                                        $etiqueta->update = True;
                                    @endphp
                                @endif
                                @if(auth()->user()->hasTeamPermission($team, 'delete-categoria'))
                                    {{-- Puede borrar --}}
                                    @php 
                                        $etiqueta->delete = True;
                                    @endphp
                                @endif
                                @php
                                    $etiqueta->teamRole = $user->teamRole($team)->name;
                                    // dd($team);
                                    
                                @endphp
                                <x-show-etiquetas :etiqueta="$etiqueta" :teams="$teams" :users="$users" :team="$team" :user="$user" />
                                
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
