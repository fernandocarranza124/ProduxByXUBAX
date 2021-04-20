<!-- Card Component -->
<div class="transition-all duration-150 flex w-full px-2 py-6 md:w-1/1 lg:w-1/3 h-1/3 ">
    <div class="flex flex-col items-stretch min-h-full pb-4 mb-6 transition-all duration-150 bg-white rounded-lg shadow-lg hover:shadow-2xl w-full" >
    <hr class="border-gray-300" />
    <div class="flex items-center text-center">
        <svg fill="true"  viewBox="0 0 21 21" class="w-8 h-8 text-gray-400">
                <path d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              
                    {{-- <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /> --}}
            
            
        </svg>
        <div class="ml-4 text-sm text-gray-600 leading-7 font-semibold">{{$titulo}}</div>
    </div>
        
    
    <hr class="border-gray-300" />
    <div class="row">
      <canvas id="{{$titulo}}" name={{$titulo}} height="480" width="600"></canvas>

    
    
   </div> 
      {{-- <hr class="border-gray-300" /> --}}
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>
    var year = <?php echo $year; ?>;
    var user = <?php echo $user; ?>;
    var id   = <?php echo $titulo; ?>;
    var barChartData = {
        labels: year,
        datasets: [{
            label: 'User',
            backgroundColor: "pink",
            data: user
        }]
    };

    window.onload = function() {
        
        var ctx = id.getContext("2d");
        var <?php echo $titulo; ?>  = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Yearly User Joined'
                }
            }
        });
    };
</script>
  {{--  --}}
  {{--  --}}