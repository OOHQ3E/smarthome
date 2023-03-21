@extends('layouts.app')

@section('title') {{'Video live feed '}} @endsection

@section('content')
<!DOCTYPE html>
<head>
    <title>{{$device->name}}'s live camera feed</title>
</head>
<html>
<div class="justify-center flex flex-wrap gap-6">
    <div class="lg:w-16 md:w-full w-full">
        <a href="{{ asset('/') }}" >
            <button type="button" class="text-4xl my-3 mx-5 text-center pb-1 font-black lg:w-16 md:w-11/12 w-11/12 h-16 bg-gray-400 rounded-full hover:bg-gray-500">
                &larr;
            </button>
        </a>
    </div>

    <div class="my-4 text-center lg:w-6/12 sm:w-10/12">
        <h1 class="text-2xl text-white font-sans py-2 uppercase font-light">
            {{$device->name}}'s live camera feed
        </h1>
    </div>

</div>
<div class="m-auto bg-opacity-75 bg-white rounded-md w-10/12 my-3 p-3 w-10/12">
    <img class="rounded-lg w-10/12 m-auto" src="http://192.168.200.{{$device->ip_End}}/" alt="">
</div>
</html>
