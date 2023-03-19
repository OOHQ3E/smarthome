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
        <div class="bg-white bg-opacity-75 shadow-2xl p-4 rounded-lg m-auto lg:w-10/12 md:w-10/12 w-full my-2">
            <p class="text-left font-bold m-2 text-xl">{{$room->name}}</p>
            <div class="flex flex-wrap gap-4 justify-center">
                @forelse($esps as $esp)
                    @if($esp-> room_id === $room->id && $esp->type === "Sensor")
                        <div class="w-full text-xl justify-center">
                            <a href="{{ asset('chart/'.$esp->room_id) }}">
                                <div class="h-min-24 bg-opacity-75 bg-gray-400 hover:bg-gray-500 p-4 rounded-lg">
                                    <p id="espData-{{$esp->room_id}}" class="">
                                        <!--Temperature: 30°C<br> Humidity: 70% -->
                                    </p>
                                </div>
                            </a>
                        </div>
                        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
                        <script>
                            $(document).ready(function (){
                                getLatestSensorData(@json($esp));
                                setInterval(getLatestSensorData.bind('esp',@json($esp)), 10000);
                            });
                        </script>

                    @elseif($esp-> room_id === $room->id && $esp->type === "Toggle")
                        <div class="w-full h-min-24 bg-opacity-75 bg-gray-400 p-4 rounded-lg">
                            <label for="toggle-{{$esp->ip_End}}" class="inline-flex relative items-center cursor-pointer">
                                <div class="grid lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1">
                                    <div class="">
                                        <input type="checkbox" value="" id="toggle-{{$esp->ip_End}}" class="sr-only peer" onclick="toggle({{$esp->ip_End}})">
                                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    </div>
                                <span id="device-{{$esp->ip_End}}-span" class="mt-0.5 text-xl text-gray-900 dark:text-gray-800"></span>
                                </div>
                            </label>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
                        <script>
                            $(document).ready(function(){
                                getStatusOfDevice(@json($esp));
                            });
                        </script>

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
            function getLatestSensorData(esp){
            $.getJSON('http://192.168.200.1/esp/getLatest/'+esp.room_id, function(data) {
            var text = `<span class="font-semibold">Temperature:</span> ${data.temperature}°C<br> <span class="font-semibold">Humidity:</span> ${data.humidity}%`
            document.getElementById("espData-"+esp.room_id).innerHTML = text;
        }).fail(function (){
            document.getElementById("espData-"+esp.room_id).innerHTML = "Data currently unavailable from <span class='font-semibold'>"+esp.name+" ("+esp.ip_End+")</span>";
        });
        }

        function getStatusOfDevice(esp){
            $.getJSON('http://192.168.200.1/getStatus/'+esp.ip_End, function(data) {
                document.getElementById("toggle-"+esp).disabled = false;
                var text = `${data.status}`
                var state;
                if(text == 1){
                    state = "on";
                    document.getElementById("toggle-"+esp.ip_End).checked = true;
                }
                if (text == 0){
                    state = "off";
                    document.getElementById("toggle-"+esp.ip_End).checked = false;
                }
                document.getElementById("device-"+esp.ip_End+"-span").innerHTML = "{{$esp->name}}: <span class='font-semibold'>"+state+"</span>";
            }).fail(function(){
                document.getElementById("device-"+esp.ip_End+"-span").innerHTML = "<span class='font-semibold'>"+esp.name+" ("+esp.ip_End+")</span> is currently unavailable";
                document.getElementById("toggle-"+esp.ip_End).checked = false;
                document.getElementById("toggle-"+esp.ip_End).disabled = true;
            });

        }

        function toggle(esp){
            var device = document.getElementById("toggle-"+esp).checked;
            var text = device? "on":"off";
            $.getJSON('http://192.168.200.1/esp/toggle/'+esp+'/'+text, function() {
                getStatusOfDevice(esp);
            }).fail(function(){
                document.getElementById("device-"+esp+"-span").innerHTML = "{{$esp->name}} is currently unavailable";
                document.getElementById("toggle-"+esp).checked = false;
                document.getElementById("toggle-"+esp).disabled = true;
            });
        }
    </script>


