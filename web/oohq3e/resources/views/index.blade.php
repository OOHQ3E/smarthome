@extends('layouts.app')

@section('title') {{'Index Page'}} @endsection

@section('content')
    <div class="w-16 h-16">
        <a class="w-full rounded-full" href="{{ asset('settings') }}" >
            <div class="text-3xl text-center w-16 h-16 bg-gray-400 rounded-full text-center m-3 p-3 hover:bg-gray-500">
                &#9881;&#65039;
            </div>
        </a>
    </div>
   <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">

    @forelse($rooms as $room)
        <div class="bg-white bg-opacity-75 shadow-2xl p-4 rounded-lg m-auto w-10/12 my-4">
            <p class="text-left font-bold m-2 text-xl">{{$room->name}}</p>
            <div class="flex flex-wrap gap-4 justify-center">
                @forelse($esps as $esp)
                    @if($esp-> room_id === $room->id && $esp->type === "Sensor")
                        <div class="w-full text-xl justify-center">
                            <a href="{{ asset('chart/'.$esp->room_id) }}">
                                <div class="h-24 bg-opacity-75 bg-gray-400 hover:bg-gray-500 p-4 rounded-lg">
                                    <p id="espData-{{$esp->room_id}}" class="">
                                        <!--Temperature: 30°C<br> Humidity: 70% -->
                                    </p>
                                </div>
                            </a>
                        </div>

                    @elseif($esp-> room_id === $room->id && $esp->type === "Toggle")
                        <div class="w-full text-center bg-opacity-75 bg-gray-400 p-4 rounded-lg">
                            <label for="toggle-{{$esp->ip_End}}" class="inline-flex relative items-center cursor-pointer">
                                <input type="checkbox" value="" id="toggle-{{$esp->ip_End}}" class="sr-only peer" onclick="toggle({{$esp->ip_End}})">
                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span id="device-{{$esp->ip_End}}-span" class="ml-3 text-lg font-medium text-gray-900 dark:text-gray-800"></span>
                            </label>
                        </div>
                    @endif

                @empty
                @endforelse
            </div>

        </div>
            @empty
        <div class="bg-white bg-opacity-75 shadow-2xl p-4 rounded-lg m-auto lg:w-3/4 sm:w-10/12 my-4">
            <p class="text-left font-bold m-2 text-xl">There are no rooms added to the database!</p>
        </div>
    @endforelse
   </div>

 <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
 <script>

	 getLatest(1);
        setInterval(getLatest.bind('room',1), 10000)
        function getLatest(room){
            $.getJSON('http://192.168.200.1/esp/getLatest/'+room, function(data) {
                var text = `<span class="font-semibold">Temperature:</span> ${data.temperature}°C<br> <span class="font-semibold">Humidity:</span> ${data.humidity}%`
                    document.getElementById("espData-"+room).innerHTML = text;
		}).fail(function (){
                document.getElementById("espData-"+room).innerHTML = "Data currently unavailable from {{$esp->name}}";
            });

       }

        getStatusOfLed(6);
        function getStatusOfLed(esp){
           $.getJSON('http://192.168.200.1/getStatus/'+esp, function(data) {
               document.getElementById("toggle-"+esp).disabled = false;
               var text = `${data.status}`
               var state;
               if(text == 1){
                   state = "on";
                   document.getElementById("toggle-"+esp).checked = true;
               }
               if (text == 0){
                   state = "off";
                   document.getElementById("toggle-"+esp).checked = false;
               }
               document.getElementById("device-"+esp+"-span").innerHTML = "{{$esp->name}} is: <span class='font-bold'>"+state+"</span>";
               //console.log(text);

           }).fail(function(){
                   document.getElementById("device-"+esp+"-span").innerHTML = "{{$esp->name}} is currently unavailable";
                    document.getElementById("toggle-"+esp).checked = false;
                   document.getElementById("toggle-"+esp).disabled = true;
           });

       }

        function toggle(esp){
            var device = document.getElementById("toggle-"+esp).checked;
            var text = device? "on":"off";
            $.getJSON('http://192.168.200.1/esp/toggle/'+esp+'/'+text, function(/*data*/) {
                //var resp = `${data.status}`
                //console.log(led_1);
                //console.log(text);
                //console.log(resp);
                getStatusOfLed(esp);
            }).fail(function(){
                document.getElementById("device-"+esp+"-span").innerHTML = "{{$esp->name}} is currently unavailable";
                document.getElementById("toggle-"+esp).checked = false;
                document.getElementById("toggle-"+esp).disabled = true;
            });
        }




    </script>

