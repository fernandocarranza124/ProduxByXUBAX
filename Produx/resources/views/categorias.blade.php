<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categorias') }}
        </h2>

    </x-slot>
    {{--             dd($user->hasTeamPermission($team, 'create-product'));
 --}}
    @if($user->hasTeamPermission($team, 'create-categoria'))
        <x-agregar-categoria-modal />
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
                        @isset($categorias)
                            @foreach($categorias as $categoria)
                                @if(auth()->user()->hasTeamPermission($team, 'update-categoria'))
                                    {{-- Puede editar --}}
                                    @php 
                                        $categoria->update = True;
                                    @endphp
                                @endif
                                @if(auth()->user()->hasTeamPermission($team, 'delete-categoria'))
                                    {{-- Puede borrar --}}
                                    @php 
                                        $categoria->delete = True;
                                    @endphp
                                @endif
                                @php
                                    $categoria->teamRole = $user->teamRole($team)->name;
                                    // dd($teams);
                                    
                                @endphp
                                <x-show-categoria :categoria="$categoria" :teams="$teams" :users="$users" />
                                
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
