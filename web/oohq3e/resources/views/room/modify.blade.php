@extends('layouts.app')

@section('title') {{'Modify Room'}} @endsection

@section('content')
    <head>
        <title>Modify {{$room->name}}</title>
    </head>
    <div class="m-auto w-1/2 py-2">
        <div class="text-center">
            <h1 class="text-3xl text-white font-sans pb-2 mt-2 uppercase font-light">
                Modify room: <span class="font-semibold">{{$room->name}}</span>
            </h1>
        </div>
    </div>

    @if(session()->has('error') || $errors->any())
        <ul class="shadow-2xl bg-red-600 rounded-lg w-1/3 m-auto text-xl text-center text-white font-sans py-2 my-2 font-light">
            <li>
                {{ session()->get('error') }}
            </li>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="m-auto text-center">
        <form action="/modify/room/{{$room->id}}" method="POST" class="shadow-2xl lg:w-2/3 m-auto px-10 py-5 bg-gray-100 rounded-lg form-input">
            @csrf

            <div class="text-left w-11/12 m-auto">
                <label for="name" class="my-6 font-semibold text-left">Room name:</label>
                <input value="{{$room->name}}" type="text" class="truncate ... my-5 w-full text-xl rounded-md" id="name" name="name" class="rounded" max="50" required>
            </div>

            <div class="text-gray-50 flex flex-wrap justify-center gap-2">
                <button id="submit" type="submit" class="shadow-xl truncate uppercase bg-green-500 rounded-full lg:w-64 md:w-64 w-11/12 text-center p-3 my-2 hover:bg-green-400">
                    <i class="fa-regular fa-pen-to-square"></i><span> Apply Changes</span>
                </button>

                <button id="reset" type="reset" class="shadow-xl text-black truncate uppercase bg-orange-500 rounded-full lg:w-64 md:w-64 w-11/12 text-center p-3 my-2 hover:bg-orange-400">
                    <i class="fa-solid fa-rotate-right"></i><span> Reset data</span>
                </button>

                <button id="cancel" onclick="location.href='{{ asset('settings') }}'" type="button" class="shadow-xl truncate text-white uppercase bg-red-500 hover:bg-red-400 lg:w-64 md:w-64 w-11/12 rounded-full text-center p-3 my-2">
                    <i class="fa-solid fa-ban"></i><span> Cancel</span>
                </button>
            </div>

        </form>

    </div>

@endsection
