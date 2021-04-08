<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuarios') }}
        </h2>

    </x-slot>
    <x-agregar-usuario-modal :team="$team" :roles="$roles" />
    <div class="py-12" style="padding-top: 1rem;padding-left: 2rem;padding-right:2rem;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                <table class="border-collapse w-full">
                    <thead>
                        <tr>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Nombre</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Correo electronico</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Equipos</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Roles</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableDevices">
                        @foreach($users as $user)
                            @if(auth()->user()->hasTeamPermission($team, 'update-member'))
                                {{-- Puede editar --}}
                                @php 
                                    $user->update = True;
                                @endphp
                            @endif
                            @if(auth()->user()->hasTeamPermission($team, 'delete-member'))
                                {{-- Puede borrar --}}
                                @php 
                                    $user->delete = True;
                                @endphp
                            @endif
                            @php
                                $user->teamRole = $user->teamRole($team)->name;
                            @endphp
                            <x-show-users :user="$user" />
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</x-app-layout>
