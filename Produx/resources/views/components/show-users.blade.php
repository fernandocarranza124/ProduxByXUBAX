<tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nombre</span>
        {{$name}}
    </td>
    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Categoria</span>
        {{$email}}
    </td>
    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Accion</span>
        @foreach($teams as $team)
            @if(!empty($team))
        <span class="rounded bg-green-400 py-1 px-3 text-xs font-bold">{{$team->name}}</span>
            @endif
        @endforeach
    </td>
    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Accion</span>
        @foreach($roles as $role)
            @if(!empty($role))
        <span class="rounded bg-green-400 py-1 px-3 text-xs font-bold">{{$role}}</span>
            @endif
        @endforeach
    </td>
    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Acciones</span>
        <a href="#" class="text-blue-400 hover:text-blue-600 underline">Editar</a>
        <a href="#" class="text-blue-400 hover:text-blue-600 underline pl-6">Borrar</a>
        <form action="" method="DELETE" accept-charset="utf-8">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit">Borrar</button>
        </form>
        
    </td>
</tr>