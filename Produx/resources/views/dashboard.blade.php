<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12" style="
    padding-top: 1rem;padding-left: 2rem;padding-right:2rem;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @php
                    // dd($DispositivosTotal);
                    // $dispositivos = 4;
                    
                @endphp
                <x-general-dashboard :dispositivos="$dispositivos" :acciones="$acciones" />
                {{-- <x-show-categoria :categoria="$categoria" :teams="$teams" :users="$users" /> --}}
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    window.onload = function() {
        
        // $("a").click();
        
    }
</script>
