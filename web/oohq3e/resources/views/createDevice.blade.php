@extends('layouts.app')

@section('title') {{'Add device to Room'}} @endsection

@section('content')
    <head>
        <title>Add device to {{$room->name}}</title>
    </head>
        <div class="m-auto w-1/2 py-2">
            <div class="text-center">
                <h1 class="text-3xl text-white font-sans pb-2 mt-2 uppercase font-light">
                   Add device to {{$room->name}}
                </h1>
            </div>
        </div>

    @if(session()->has('error') || $errors->any())
        <ul class="bg-red-600 rounded-lg w-1/3 m-auto text-xl text-center text-white font-sans py-2 my-2 font-light">
                <li>
                    {{ session()->get('error') }}
                </li>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

        <div class="m-auto text-center">
            <form action="/create/device/{{$room->id}}" method="POST" class="lg:w-2/3 m-auto px-10 py-5 bg-gray-100 rounded-lg form-input">
                @csrf
                <input type="hidden" id="roomId" name="roomId" value="{{$room->id}}">
                <div class="text-left w-11/12 m-auto">
                    <label for="type" class="my-6 font-semibold">Device type:</label>

                    <select name="type" id="type" class="my-5 text-xl w-full m-auto rounded-md">
                        <?php $i = 0; ?>

                        @foreach($types as $type)
                            <option value="{{$i}}">{{$type}}</option>

                            <?php $i = $i +1; ?>
                        @endforeach
                    </select>
                </div>
                <div class="text-left w-11/12 m-auto">
                    <label for="device-name" class="my-6 font-semibold text-left">Device name:</label>
                    <input type="text" class="truncate ... my-5 w-full text-xl rounded-md" id="deviceName" name="deviceName" class="rounded" required>
                </div>
                <div class="text-black  grid grid-cols-5 lg:w-1/2 md:w-2/3 w-11/12 m-auto my-3">
                    <span class="font-semibold">IP:</span>
                    <input type="text" class="w-11/12 text-center rounded-full" value="192." disabled>
                    <input type="text" class="w-11/12 text-center rounded-full" value="168." disabled>
                    <input type="text" class="w-11/12 text-center rounded-full" value="200." disabled>
                    <input type="number" id="ip_End" name="ip_End" class="w-11/12 text-center rounded-full" min="2" max="150">
                </div>

                <div class="text-center text-gray-50 grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                    <button type="submit" class="truncate uppercase bg-green-500 rounded-full lg:w-11/12 md:w-10/12 w-full text-center p-3 my-2 hover:bg-green-400">Add</button>
                    <button type="reset" class="truncate uppercase bg-orange-500 rounded-full lg:w-11/12 md:w-10/12 w-full text-center p-3 my-2 hover:bg-orange-400">Reset data</button>
                    <a class="lg:w-11/12 md:w-10/12 w-full" href="{{ asset('settings') }}" >
                        <button type="button" class="truncate text-black uppercase bg-red-500 hover:bg-red-400 rounded-full w-full text-center p-3 my-2">
                            Cancel
                        </button>
                    </a>
                </div>

            </form>

        </div>

@endsection
