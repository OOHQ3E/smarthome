@extends('layouts.app')

@section('title') {{'Index Page'}} @endsection

@section('content')


    <div class="m-auto p-4 lg:text-left md:text-center sm:text-center">
        <button class="lg:w-16 md:w-11/12 w-full h-16 text-3xl text-gray-700 transition hover:text-gray-800 rounded-full bg-gray-400 rounded-full hover:bg-gray-500" onclick="location.href='{{ asset('settings') }}'">
            <i class="fa-solid fa-gear"></i>
        </button>
    </div>

   <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">

    @forelse($rooms as $room)
        <div class="bg-white bg-opacity-75 shadow-2xl p-4 rounded-lg m-auto lg:w-10/12 md:w-10/12 w-full my-2">
            <p class="text-left font-bold m-2 text-2xl">{{$room->name}}</p>
            <div class="flex flex-wrap gap-4 justify-center">
                @forelse($esps as $esp)
                    @if($esp-> room_id === $room->id && $esp->type === "Sensor")
                        <div onclick="location.href='{{ asset('chart/'.$esp->room_id) }}'" class="hover:cursor-pointer w-full text-xl justify-center">
                            <div class="h-min-24 bg-opacity-75 bg-gray-400 hover:bg-gray-500 p-4 rounded-lg">
                                <p id="espData-{{$esp->room_id}}" class="">
                                    <!--Temperature: 30°C<br> Humidity: 70% -->
                                </p>
                            </div>
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
                            <label for="toggle-{{$esp->ip_End}}" class="w-full h-full inline-flex relative items-center cursor-pointer">
                                <div class="">
                                        <input type="checkbox" value="" id="toggle-{{$esp->ip_End}}" class="sr-only peer" onclick='toggle(@json($esp))'>
                                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                        </div>
                                <span id="device-{{$esp->ip_End}}-span" class="mt-0.5 text-xl text-gray-900 dark:text-gray-800"></span>
                                </div>
                            </label>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
                        <script>
                            $(document).ready(function(){
                                document.getElementById("device-{{$esp->ip_End}}-span").innerHTML = "Connecting to <span class='font-semibold'>{{$esp->name}} ({{$esp->ip_End}})</span> ...";
                                getStatusOfDevice(@json($esp));
                            });
                        </script>
                    @elseif($esp-> room_id === $room->id && $esp->type === "Camera")
                        <a class="w-full" id="camera-{{$esp->ip_End}}-link" href="{{ asset('cam/'.$esp->ip_End) }}">
                        <div class="w-full h-min-24 bg-opacity-75 bg-gray-400 p-4 rounded-lg">
                            <span id="device-{{$esp->ip_End}}-span" class="my-0.5 text-xl text-gray-900 dark:text-gray-800"></span>
                             <img id="camera-{{$esp->ip_End}}" onload='success(@json($esp))' class="rounded-lg w-full m-auto" src="http://192.168.200.{{$esp->ip_End}}/">
                        </div>
                        </a>
                        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
                        <script>
                            $(document).ready(function(){
                                document.getElementById("device-{{$esp->ip_End}}-span").innerHTML = "Connecting to <span class='font-semibold'>{{$esp->name}} ({{$esp->ip_End}})</span> ...";

                                //document.getElementById("camera-{{$esp->ip_End}}").addEventListener("load",success(@json($esp),"http://192.168.200.{{$esp->ip_End}}"));
                                document.getElementById("camera-{{$esp->ip_End}}").addEventListener("error",error(@json($esp),"http://192.168.200.{{$esp->ip_End}}"));
                                setInterval(imageExists.bind('esp',@json($esp),"http://192.168.200.{{$esp->ip_End}}"), 15000);
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
            document.getElementById("espData-"+esp.room_id).innerHTML = "Connecting to <span class='font-semibold'>"+esp.name+"</span>...";
            var text = `<span class="font-semibold">Temperature:</span> ${data.temperature}°C<br> <span class="font-semibold">Humidity:</span> ${data.humidity}%`
            document.getElementById("espData-"+esp.room_id).innerHTML = text;
        }).fail(function (){
            document.getElementById("espData-"+esp.room_id).innerHTML = "Data currently unavailable from <span class='font-semibold'>"+esp.name+" ("+esp.ip_End+")</span>";
        });
        }

        function getStatusOfDevice(esp){
            $.getJSON('http://192.168.200.1/getStatus/'+esp.ip_End, function(data) {
                document.getElementById("toggle-"+esp.ip_End).disabled = false;
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
                document.getElementById("device-"+esp.ip_End+"-span").innerHTML = esp.name+": <span class='font-semibold'>"+state+"</span>";
            }).fail(function(){
                document.getElementById("device-"+esp.ip_End+"-span").innerHTML = "<span class='font-semibold'>"+esp.name+" ("+esp.ip_End+")</span> is currently unavailable";
                document.getElementById("toggle-"+esp.ip_End).checked = false;
                document.getElementById("toggle-"+esp.ip_End).disabled = true;
            });

        }

        function toggle(esp){
            var device = document.getElementById("toggle-"+esp.ip_End).checked;
            var text = device? "on":"off";
            $.getJSON('http://192.168.200.1/esp/toggle/'+esp.ip_End+'/'+text, function() {
                getStatusOfDevice(esp);
            }).fail(function(){
                document.getElementById("device-"+esp.ip_End+"-span").innerHTML = "<span class='font-semibold'>"+esp.name+" ("+esp.ip_End+")</span> is currently unavailable";
                document.getElementById("toggle-"+esp.ip_End).checked = false;
                document.getElementById("toggle-"+esp.ip_End).disabled = true;
            });
        }

        //Camera feed
            function success(esp){
                document.getElementById("device-"+esp.ip_End+"-span").innerHTML = "<span class='font-semibold'>"+esp.name +" ("+esp.ip_End+")</span>";
            }
            function error(esp, url){
                //console.log("error occured")
                document.getElementById("device-"+esp.ip_End+"-span").innerHTML = "An error occured with <span class='font-semibold'>"+esp.name+" ("+esp.ip_End+").</span> Trying to reconnect...";
                document.getElementById("camera-"+esp.ip_End).src = url;
            }
            function imageExists(esp,url){
                //console.log("checking availability")
                $.getJSON(url, function() {
                }).fail(function(){
                    error(esp, url);
                });
            }
    </script>


