{{-- <div>
    <script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine-ie11.min.js" defer></script>

    <style>
        [x-cloak] {
            display: none;
        }
    </style>
    <select x-cloak id="{{$titulo}}">
        @foreach ($rows as $row)
            <option value="{{$row->id}}">{{$row->nombre}}</option>    
        @endforeach
    </select>

<div x-data="dropdown()" x-init="loadOptions()" class="w-full md:w-1/2 flex flex-col items-center h-auto mx-auto">
  
      <input name="values" type="hidden" x-bind:value="selectedValues()">
      <div class="inline-block relative w-64">
          <div class="flex flex-col items-center relative">
              <div x-on:click="open" class="w-full  svelte-1l8159u">
                  <div class="my-2 p-1 flex border border-gray-200 bg-white rounded svelte-1l8159u">
                      <div class="flex flex-auto flex-wrap">
                          <template x-for="(option,index) in selected" :key="options[option].value">
                              <div
                                  class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-teal-700 bg-teal-100 border border-teal-300 ">
                                  <div class="text-xs font-normal leading-none max-w-full flex-initial x-model="
                                      options[option]" x-text="options[option].text"></div>
                                  <div class="flex flex-auto flex-row-reverse">
                                      <div x-on:click="remove(index,option)">
                                          <svg class="fill-current h-6 w-6 " role="button" viewBox="0 0 20 20">
                                              <path d="M14.348,14.849c-0.469,0.469-1.229,0.469-1.697,0L10,11.819l-2.651,3.029c-0.469,0.469-1.229,0.469-1.697,0
                                         c-0.469-0.469-0.469-1.229,0-1.697l2.758-3.15L5.651,6.849c-0.469-0.469-0.469-1.228,0-1.697s1.228-0.469,1.697,0L10,8.183
                                         l2.651-3.031c0.469-0.469,1.228-0.469,1.697,0s0.469,1.229,0,1.697l-2.758,3.152l2.758,3.15
                                         C14.817,13.62,14.817,14.38,14.348,14.849z" />
                                          </svg>

                                      </div>
                                  </div>
                              </div>
                          </template>
                          <div x-show="selected.length    == 0" class="flex-1">
                              <input placeholder="Select a option"
                                  class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-gray-800"
                                  x-bind:value="selectedValues()"
                              >
                          </div>
                      </div>
                      <div
                          class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200 svelte-1l8159u">

                          <button type="button" x-show="isOpen() === true" x-on:click="open"
                              class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                              <svg version="1.1" class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                  <path d="M17.418,6.109c0.272-0.268,0.709-0.268,0.979,0s0.271,0.701,0,0.969l-7.908,7.83
  c-0.27,0.268-0.707,0.268-0.979,0l-7.908-7.83c-0.27-0.268-0.27-0.701,0-0.969c0.271-0.268,0.709-0.268,0.979,0L10,13.25
  L17.418,6.109z" />
                              </svg>

                          </button>
                          <button type="button" x-show="isOpen() === false" @click="close"
                              class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                              <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                  <path d="M2.582,13.891c-0.272,0.268-0.709,0.268-0.979,0s-0.271-0.701,0-0.969l7.908-7.83
  c0.27-0.268,0.707-0.268,0.979,0l7.908,7.83c0.27,0.268,0.27,0.701,0,0.969c-0.271,0.268-0.709,0.268-0.978,0L10,6.75L2.582,13.891z
  " />
                              </svg>

                          </button>
                      </div>
                  </div>
              </div>
              <div class="w-full px-4">
                  <div x-show.transition.origin.top="isOpen()"
                      class="absolute shadow top-100 bg-white z-40 w-full lef-0 rounded max-h-select overflow-y-auto svelte-5uyqqj"
                      x-on:click.away="close">
                      <div class="flex flex-col w-full">
                          <template x-for="(option,index) in options" :key="option">
                              <div>
                                  <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-teal-100"
                                      @click="select(index,$event)">
                                      <div x-bind:class="option.selected ? 'border-teal-600' : ''"
                                          class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative">
                                          <div class="w-full items-center flex">
                                              <div class="mx-2 leading-6" x-model="option" x-text="option.text"></div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </template>
                      </div>
                  </div>
              </div>
          </div>
          <!-- on tailwind components page will no work  -->
      </form>
      </div>
      

      <script>
          function dropdown() {
              return {
                  options: [],
                  selected: [],
                  show: false,
                  open() { this.show = true },
                  close() { this.show = false },
                  isOpen() { return this.show === true },
                  select(index, event) {

                      if (!this.options[index].selected) {

                          this.options[index].selected = true;
                          this.options[index].element = event.target;
                          this.selected.push(index);

                      } else {
                          this.selected.splice(this.selected.lastIndexOf(index), 1);
                          this.options[index].selected = false
                      }
                  },
                  remove(index, option) {
                      this.options[option].selected = false;
                      this.selected.splice(index, 1);


                  },
                  loadOptions() {
                      const options = document.getElementById("{{$titulo}}").options;
                      for (let i = 0; i < options.length; i++) {
                          this.options.push({
                              value: options[i].value,
                              text: options[i].innerText,
                              selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                          });
                      }


                  },
                  selectedValues(){
                      return this.selected.map((option)=>{
                          return this.options[option].value;
                      })
                  }
              }
          }
      </script>
</div> --}}

<style>
    [x-cloak] {
  display: none;
}

.svg-icon {
  width: 1em;
  height: 0.5rem;
}

.svg-icon path,
.svg-icon polygon,
.svg-icon rect {
  fill: #333;
}

.svg-icon circle {
  stroke: #4691f6;
  stroke-width: 1;
}
</style>
<script>
    function dropdown() {
                return {
                    options: [],
                    selected: [],
                    show: false,
                    open() { this.show = true },
                    close() { this.show = false },
                    isOpen() { return this.show === true },
                    select(index, event) {

                        if (!this.options[index].selected) {

                            this.options[index].selected = true;
                            this.options[index].element = event.target;
                            this.selected.push(index);

                        } else {
                            this.selected.splice(this.selected.lastIndexOf(index), 1);
                            this.options[index].selected = false
                        }
                    },
                    remove(index, option) {
                        this.options[option].selected = false;
                        this.selected.splice(index, 1);


                    },
                    loadOptions() {
                        const options = document.getElementById("{{$titulo}}").options;
                        for (let i = 0; i < options.length; i++) {
                            this.options.push({
                                value: options[i].value,
                                text: options[i].innerText,
                                selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                            });
                        }


                    },
                    selectedValues(){
                        return this.selected.map((option)=>{
                            return this.options[option].value;
                        })
                    }
                }
            }
</script>


<select x-cloak id="{{$titulo}}">
    @foreach ($rows as $row)
        <option value="{{$row->id}}">{{$row->nombre}}</option>    
    @endforeach
  </select>
  
  <div x-data="dropdown()" x-init="loadOptions()" class="w-full md:w-1/3 flex flex-col items-center h-auto mx-auto">
    <input name="values" type="hidden" x-bind:value="selectedValues()">
    <div class="inline-block relative w-64">
      <div class="flex flex-col items-center relative">
        <div x-on:click="open" class="w-full">
          <div class="my-2 p-1 flex border border-gray-200 bg-white rounded">
            <div class="flex flex-auto flex-wrap">
              <template x-for="(option,index) in selected" :key="options[option].value">
                <div class="flex justify-center items-center m-1 font-medium py-1 px-1 bg-white rounded bg-gray-100 border">
                  <div class="text-xs font-normal leading-none max-w-full flex-initial x-model=" options[option] x-text="options[option].text"></div>
                  <div class="flex flex-auto flex-row-reverse">
                    <div x-on:click.stop="remove(index,option)">
                      <svg class="fill-current h-4 w-4 " role="button" viewBox="0 0 20 20">
                        <path d="M14.348,14.849c-0.469,0.469-1.229,0.469-1.697,0L10,11.819l-2.651,3.029c-0.469,0.469-1.229,0.469-1.697,0
                                             c-0.469-0.469-0.469-1.229,0-1.697l2.758-3.15L5.651,6.849c-0.469-0.469-0.469-1.228,0-1.697s1.228-0.469,1.697,0L10,8.183
                                             l2.651-3.031c0.469-0.469,1.228-0.469,1.697,0s0.469,1.229,0,1.697l-2.758,3.152l2.758,3.15
                                             C14.817,13.62,14.817,14.38,14.348,14.849z" />
                      </svg>
  
                    </div>
                  </div>
                </div>
              </template>
              <div x-show="selected.length == 0" class="flex-1">
                <input placeholder="Seleccione una categoria" class="bg-transparent p-1 px-2 appearance-none outline-none h-1/5 w-full text-gray-800" x-bind:value="selectedValues()">
              </div>
            </div>
            <div class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200 svelte-1l8159u">
  
              <button type="button" x-show="isOpen() === true" x-on:click="open" class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                <svg version="1.1" class="fill-current h-4 w-4" viewBox="0 0 20 20">
                  <path d="M17.418,6.109c0.272-0.268,0.709-0.268,0.979,0s0.271,0.701,0,0.969l-7.908,7.83
      c-0.27,0.268-0.707,0.268-0.979,0l-7.908-7.83c-0.27-0.268-0.27-0.701,0-0.969c0.271-0.268,0.709-0.268,0.979,0L10,13.25
      L17.418,6.109z" />
                </svg>
  
              </button>
              <button type="button" x-show="isOpen() === false" @click="close" class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                  <path d="M2.582,13.891c-0.272,0.268-0.709,0.268-0.979,0s-0.271-0.701,0-0.969l7.908-7.83
      c0.27-0.268,0.707-0.268,0.979,0l7.908,7.83c0.27,0.268,0.27,0.701,0,0.969c-0.271,0.268-0.709,0.268-0.978,0L10,6.75L2.582,13.891z
      " />
                </svg>
  
              </button>
            </div>
          </div>
        </div>
        <div class="w-full px-4">
          <div x-show.transition.origin.top="isOpen()" class="absolute shadow top-100 bg-white z-40 w-full left-0 rounded max-h-select" x-on:click.away="close">
            <div class="flex flex-col w-full overflow-y-auto h-64">
              <template x-for="(option,index) in options" :key="option" class="overflow-auto">
                <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-gray-100" @click="select(index,$event)">
                  <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative">
                    <div class="w-full items-center flex justify-between">
                      <div class="mx-2 leading-6" x-model="option" x-text="option.text"></div>
                      <div x-show="option.selected">
                        <svg class="svg-icon" viewBox="0 0 20 20">
                          <path fill="none" d="M7.197,16.963H7.195c-0.204,0-0.399-0.083-0.544-0.227l-6.039-6.082c-0.3-0.302-0.297-0.788,0.003-1.087
                              C0.919,9.266,1.404,9.269,1.702,9.57l5.495,5.536L18.221,4.083c0.301-0.301,0.787-0.301,1.087,0c0.301,0.3,0.301,0.787,0,1.087
                              L7.741,16.738C7.596,16.882,7.401,16.963,7.197,16.963z"></path>
                        </svg>
                      </div>
                    </div>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>







{{-- <div class="flex items-center justify-center bg-gray-200 ">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
  
    <style>
      [x-cloak] {
        display: none;
      }
    </style>
  
    <div class="antialiased sans-serif">
        <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
            <div class="container">
                <div class="mb-5 w-64">
  
                    <label for="datepicker" class="font-bold mb-1 text-gray-700 block">{{$titulo}}</label>
                    <div class="relative">
                        <input type="hidden" name="date" x-ref="date">
                        <input 
                            type="text"
                            readonly
                            x-model="datepickerValue"
                            @click="showDatepicker = !showDatepicker"
                            @keydown.escape="showDatepicker = false"
                            class="w-full pl-4 pr-10 py-3 leading-none rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                            placeholder="Select date">
  
                            <div class="absolute top-0 right-0 px-3 py-2">
                                <svg class="h-6 w-6 text-gray-400"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
  
  
                            <!-- <div x-text="no_of_days.length"></div>
                            <div x-text="32 - new Date(year, month, 32).getDate()"></div>
                            <div x-text="new Date(year, month).getDay()"></div> -->
  
                            <div 
                                class="bg-white mt-12 rounded-lg shadow p-4 absolute top-0 left-0" 
                                style="width: 17rem" 
                                x-show.transition="showDatepicker"
                                @click.away="showDatepicker = false">
  
                                <div class="flex justify-between items-center mb-2">
                                    <div>
                                        <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                                        <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                                    </div>
                                    <div>
                                        <button 
                                            type="button"
                                            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" 
                                            :class="{'cursor-not-allowed opacity-25': month == 0 }"
                                            :disabled="month == 0 ? true : false"
                                            @click="month--; getNoOfDays()">
                                            <svg class="h-6 w-6 text-gray-500 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                            </svg>  
                                        </button>
                                        <button 
                                            type="button"
                                            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" 
                                            :class="{'cursor-not-allowed opacity-25': month == 11 }"
                                            :disabled="month == 11 ? true : false"
                                            @click="month++; getNoOfDays()">
                                            <svg class="h-6 w-6 text-gray-500 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>									  
                                        </button>
                                    </div>
                                </div>
  
                                <div class="flex flex-wrap mb-3 -mx-1">
                                    <template x-for="(day, index) in DAYS" :key="index">	
                                        <div style="width: 14.26%" class="px-1">
                                            <div
                                                x-text="day" 
                                                class="text-gray-800 font-medium text-center text-xs"></div>
                                        </div>
                                    </template>
                                </div>
  
                                <div class="flex flex-wrap -mx-1">
                                    <template x-for="blankday in blankdays">
                                        <div 
                                            style="width: 14.28%"
                                            class="text-center border p-1 border-transparent text-sm"	
                                        ></div>
                                    </template>	
                                    <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">	
                                        <div style="width: 14.28%" class="px-1 mb-1">
                                            <div
                                                @click="getDateValue(date)"
                                                x-text="date"
                                                class="cursor-pointer text-center text-sm leading-none rounded-full leading-loose transition ease-in-out duration-100"
                                                :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }"	
                                            ></div>
                                        </div>
                                    </template>
                                </div>
                            </div>
  
                    </div>	 
                </div>
  
            </div>
        </div>
  
        <script>
            const MONTH_NAMES = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            const DAYS = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
  
            function app() {
                return {
                    showDatepicker: false,
                    datepickerValue: '',
  
                    month: '',
                    year: '',
                    no_of_days: [],
                    blankdays: [],
                    days: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
  
                    initDate() {
                        let today = new Date();
                        this.month = today.getMonth();
                        this.year = today.getFullYear();
                        this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
                    },
  
                    isToday(date) {
                        const today = new Date();
                        const d = new Date(this.year, this.month, date);
  
                        return today.toDateString() === d.toDateString() ? true : false;
                    },
  
                    getDateValue(date) {
                        let selectedDate = new Date(this.year, this.month, date);
                        this.datepickerValue = selectedDate.toDateString();
  
                        this.$refs.date.value = selectedDate.getFullYear() +"-"+ ('0'+ selectedDate.getMonth()).slice(-2) +"-"+ ('0' + selectedDate.getDate()).slice(-2);
  
                        console.log(this.$refs.date.value);
  
                        this.showDatepicker = false;
                    },
  
                    getNoOfDays() {
                        let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
  
                        // find where to start calendar day of week
                        let dayOfWeek = new Date(this.year, this.month).getDay();
                        let blankdaysArray = [];
                        for ( var i=1; i <= dayOfWeek; i++) {
                            blankdaysArray.push(i);
                        }
  
                        let daysArray = [];
                        for ( var i=1; i <= daysInMonth; i++) {
                            daysArray.push(i);
                        }
  
                        this.blankdays = blankdaysArray;
                        this.no_of_days = daysArray;
                    }
                }
            }
        </script>
      </div>
  </div> --}}