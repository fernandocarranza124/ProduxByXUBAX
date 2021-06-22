<!-- Card Component -->
<div class="transition-all duration-150 flex w-full px-4 py-6 md:w-1/2 lg:w-1/6" style="height: 15.2rem;">
    <div class="flex flex-col items-stretch min-h-full pb-4 mb-6 transition-all duration-150 bg-white rounded-lg shadow-lg hover:shadow-2xl w-full" >
    <hr class="border-gray-300" />
    <div class="flex items-center text-center">
        <svg fill="true" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
            @switch($icono)
                @case("chip")
                    <path fill-rule="evenodd" d="M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2h-2v1a1 1 0 11-2 0v-1H9v1a1 1 0 11-2 0v-1H5a2 2 0 01-2-2v-2H2a1 1 0 110-2h1V9H2a1 1 0 010-2h1V5a2 2 0 012-2h2V2zM5 5h10v10H5V5z" clip-rule="evenodd" />
                    @break
                @case("clock")
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    @break
                @case("stick")
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    @break
                @case("people")
                    <path fill-rule="evenodd" d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    @break
                @case("eye")
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    @break
                    
                @default
                    
            @endswitch
            
        </svg>
        <div class="ml-4 text-md text-gray-600 leading-7 font-semibold"><a href="">{{$titulo}}</a></div>
    </div>
        
    
    <hr class="border-gray-300" />
    @if ($color == "true" && $extra == "%")
        @if ($valor > 80)
            @php
            $color = "green-700";
            @endphp       
        
        @elseif ($valor > 60)
            @php
            $color = "yellow-700";
            @endphp            
        @elseif ($valor > 80)
            @php
            $color = "red-700";
            @endphp            
        @elseif ($valor > 0)
            @php
                $color = "red-700";
            @endphp       
        @endif
    @endif
      <p class="w-full px-4 py-2 overflow-hidden text-3xl text-center text-{{$color}}">
        {{$valor}} <small>{{$extra}}</small>
      </p>
      {{-- <hr class="border-gray-300" /> --}}
    </div>
  </div>
  {{--  --}}
  {{--  --}}