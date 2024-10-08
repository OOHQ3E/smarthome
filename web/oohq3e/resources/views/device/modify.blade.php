@extends('layouts.app')

@section('title') {{'Add device to Room'}} @endsection

@section('content')
    <head>
        <title>Modify {{$device->name}} in {{$room->name}}</title>
    </head>
    <div class="m-auto w-10/12 py-2">
        <div class="text-center">
            <h1 class="text-3xl text-white font-sans pb-2 mt-2 uppercase font-light">
                Modify <span class="font-semibold">{{$device->name}}</span> in <span class="font-semibold">{{$room->name}}</span>
            </h1>
        </div>
    </div>

    @if(session()->has('error') || $errors->any())
        <ul id="error_message" class="shadow-2xl bg-red-600 rounded-lg w-1/3 m-auto text-xl text-center text-white font-sans py-2 my-2 font-light">
            <li>
                {{ session()->get('error') }}
            </li>
            @foreach ($errors->all() as $error)
                <li id="error_message">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="m-auto text-center">
        <form action="/modify/device/{{$room->id}}/{{$device->id}}" method="POST" class="shadow-2xl lg:w-2/3 m-auto px-10 py-5 bg-gray-100 rounded-lg form-input">
            @csrf
            <input type="hidden" id="roomId" name="roomId" value="{{$room->id}}">
            <div class="text-left w-11/12 m-auto">
                <label for="room" class="my-6 font-semibold">Room:</label>
                <select name="room" id="room" class="my-5 text-xl w-full m-auto rounded-md">
                    @foreach($rooms as $room)
                        @if($room->id == $device->room_id)
                            <option selected value="{{$room->id}}">{{$room->name}}</option>
                        @else
                            <option  value="{{$room->id}}">{{$room->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="text-left w-11/12 m-auto">
                <label for="type" class="my-6 font-semibold">Device type:</label>

                <select name="type" id="type" class="my-5 text-xl w-full m-auto rounded-md">
                    <?php $i = 0; ?>

                    @foreach($types as $type)
                        @if($type == $device->type)
                        <option selected value="{{$i}}">{{$type}}</option>
                        @else
                        <option  value="{{$i}}">{{$type}}</option>
                        @endif
                        <?php $i = $i +1; ?>

                    @endforeach
                </select>
            </div>

            <div class="text-left w-11/12 m-auto">
                <label for="device-name" class="my-6 font-semibold text-left">Device name:</label>
                <input type="text" value="{{$device->name}}" class="truncate ... my-5 w-full text-xl rounded-md" id="deviceName" name="deviceName" class="rounded" required>
            </div>
            <div class="text-black  grid grid-cols-5 lg:w-1/2 md:w-2/3 w-11/12 m-auto my-3">
                <span class="font-semibold">IP:</span>
                <input type="text" class="w-11/12 text-center rounded-full" value="192." disabled>
                <input type="text" class="w-11/12 text-center rounded-full" value="168." disabled>
                <input type="text" class="w-11/12 text-center rounded-full" value="200." disabled>
                <input type="number" id="ip_End" name="ip_End" class="w-11/12 text-center rounded-full" min="2" max="149" value="{{$device->ip_End}}">
            </div>

            <div class="text-gray-50 flex flex-wrap justify-center gap-2">
                <button id="submit" type="submit" class="shadow-xl truncate uppercase bg-green-500 rounded-full lg:w-64 md:w-64 w-11/12 text-center p-3 my-2 hover:bg-green-400">
                    <i class="fa-regular fa-pen-to-square"></i><span> Apply Changes</span>
                </button>

                <button id="reset" type="reset" class="shadow-xl text-black truncate uppercase bg-orange-500 rounded-full lg:w-64 md:w-64 w-11/12 text-center p-3 my-2 hover:bg-orange-400">
                    <i class="fa-solid fa-rotate-right"></i><span> Reset Data</span>
                </button>

                <button id="cancel" onclick="location.href='{{ asset('settings') }}'" type="button" class="shadow-xl truncate text-white uppercase bg-red-500 hover:bg-red-400 lg:w-64 md:w-64 w-11/12 rounded-full text-center p-3 my-2">
                    <i class="fa-solid fa-ban"></i><span> Cancel</span>
                </button>
            </div>

        </form>

    </div>

@endsection
