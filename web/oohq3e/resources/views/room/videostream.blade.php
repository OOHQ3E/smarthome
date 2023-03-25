@extends('layouts.app')

@section('title') {{'Video live feed '}} @endsection

@section('content')
<!DOCTYPE html>
<head>
    <title>{{$device->name}}'s live camera feed</title>
</head>
<html>
<div class="p-5 text-center m-auto w-full flex flex-wrap gap-4">
    <button class="shadow-2xl lg:w-16 text-3xl md:w-full w-full h-16 text-gray-700 transition hover:text-gray-800 rounded-full font-black bg-gray-400 rounded-full hover:bg-gray-500"  onclick="location.href='{{ asset('/') }}'">
        <i class="fa-solid fa-arrow-left"></i>
    </button>

    <div class="my-4 text-center w-11/12 m-auto">
        <h1 class="text-3xl text-white font-sans py-2 uppercase font-light">
            {{$device->name}}'s live camera feed
        </h1>
    </div>

</div>
<div class="m-auto bg-opacity-75 shadow-2xl bg-white rounded-md w-10/12 my-3 p-3 w-10/12 text-center">
    <span id="device-{{$device->ip_End}}-span" class="my-0.5 text-xl text-gray-900 dark:text-gray-800 ">
    </span>
    <img src="http://192.168.200.{{$device->ip_End}}/" onload='success(@json($device))' id="camera-{{$device->ip_End}}" class="rounded-lg w-10/12 m-auto"  alt="">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function(){
            imageExists.bind('device',@json($device),"http://192.168.200.{{$device->ip_End}}");
            document.getElementById("device-{{$device->ip_End}}-span").innerHTML = "Connecting to <span class='font-semibold'>{{$device->name}} ({{$device->ip_End}})</span> ...";

            //document.getElementById("camera-{{$device->ip_End}}").addEventListener("load",success(@json($device),"http://192.168.200.{{$device->ip_End}}"));
            document.getElementById("camera-{{$device->ip_End}}").addEventListener("error",error(@json($device),"http://192.168.200.{{$device->ip_End}}"));

            setInterval(imageExists.bind('device',@json($device),"http://192.168.200.{{$device->ip_End}}"), 15000);
        });
    </script>
</div>
</html>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
        function success(device){
            document.getElementById("device-"+device.ip_End+"-span").innerHTML = "";
        }
        function error(device, url){
           //console.log("error occured")
           document.getElementById("device-"+device.ip_End+"-span").innerHTML = "<span class='font-semibold'>An error occured with "+device.name+" ("+device.ip_End+").</span> Trying to reconnect...";
           document.getElementById("camera-"+device.ip_End).src = url;
        }
        function imageExists(device,url){
            //console.log("checking availability")
            $.getJSON(url, function() {
            }).fail(function(){
                error(device, url);
            });
        }
</script>
