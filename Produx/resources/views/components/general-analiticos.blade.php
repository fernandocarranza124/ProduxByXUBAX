<section class="flex flex-row flex-wrap mx-auto">
    <x-cards-info-analiticos titulo="OTS" icono="chip" />    
    <x-cards-info-analiticos titulo="Watchers" icono="chip" />    
    <x-cards-info-analiticos titulo="Conversion ratio" icono="stick" />    
    <x-cards-info-analiticos titulo="Dwell time" icono="clock" />    
    <x-cards-info-analiticos titulo="Attention time" icono="clock" />    
    <x-cards-info-analiticos titulo="Attraction ratio" icono="stick" />    
</section>

<section class="flex flex-row flex-wrap mx-auto">
    @php
        
    @endphp
    <x-chart-info-analiticos :year="$year" :user="$user" titulo="OTS_Watchers" />    
    <x-chart-info-analiticos :year="$year" :user="$user" titulo="OTS_Semanal" />    
    {{-- <x-chart-info-analiticos :year="$year" :user="$user" titulo="OTS_diario" />     --}}
</section>