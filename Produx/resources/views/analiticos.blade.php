<x-app-layout>    
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analiticos') }}
        </h2>
    </x-slot> --}}
    
    <div class="py-12" style="
    padding-top: 1rem;padding-left: 2rem;padding-right:2rem;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                <x-general-analiticos :infos="$infos" :categorias="$categoriasPorEquipo" :dispositivos="$DispositivosTodos" :fechaActual="$fechaActual" :seemetrix="$seemetrix" />
                
            </div>
        </div>
    </div>
</x-app-layout>
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
    