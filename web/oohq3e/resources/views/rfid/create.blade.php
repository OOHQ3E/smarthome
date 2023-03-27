@extends('layouts.app')

@section('title') {{'Add device to Room'}} @endsection

@section('content')
    <head>
        <title>Add RFID Tag</title>
    </head>
        <div class="m-auto w-1/2 py-2">
            <div class="text-center">
                <h1 class="text-3xl text-white font-sans pb-2 mt-2 uppercase font-light">
                   Add RFID Tag
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
            <form action="/create/RFID" method="POST" class="shadow-2xl lg:w-2/3 m-auto px-10 py-5 bg-gray-100 rounded-lg form-input">
                @csrf

                <div class="text-left w-11/12 m-auto">
                    <label for="name" class="lg:my-3 md:my-3 my-1 font-semibold text-left">Tag name:</label>
                    <input type="text" class="truncate ... pl-2 my-6 w-full text-xl rounded-md" id="name" name="name" class="rounded" required>

                </div>

                <div class="text-center flex lg:flex-nowrap md:flex-nowrap flex-wrap w-11/12 m-auto">
                    <label for="uid" class="lg:my-6 md:my-3 my-1 p-2 font-semibold text-left">UID: </label>
			<input type="hidden" name="uid" id="uid">
                    <input disabled type="text" class="truncate ... pl-2 lg:my-6 md:my-3 my-1 w-full text-xl rounded-md" id="uid_i" name="uid_i" class="rounded" required>

                    <button type="button" onclick="GetUID()" id="tagRead" class="shadow-xl truncate m-auto uppercase bg-cyan-600 lg:ml-2 md:ml-2 m-auto rounded-full lg:w-64 my-6 md:w-64 w-11/12 text-center lg:my-3 md:my-3 my-1 p-3 hover:bg-cyan-500">
                        <i class="fa-solid fa-id-card-clip"></i><span> Read Tag</span>
                    </button>
                </div>
                <div class="text-center flex w-11/12 m-auto">
                    <label for="name" class="lg:my-3 md:my-3 my-1 w-full text-left"><span class="font-semibold">Card Reader:</span>
                    <select onchange="changeSelected()" name="reader" id="reader" class="truncate ...  my-5 text-xl w-full m-auto rounded-md">
                        @foreach($CardReaders as $reader)
                            <option value="{{$reader->id}}">{{$reader->name}}</option>
                        @endforeach
                    </select>
                    </label>
                </div>
                <div class="text-gray-50 flex flex-wrap justify-center gap-2">
                    <button type="submit" class="shadow-xl truncate uppercase bg-green-500 rounded-full lg:w-64 md:w-64 w-11/12 text-center p-3 my-2 hover:bg-green-400">
                        <i class="fa-solid fa-plus"></i><span> Add RFID Tag</span>
                    </button>

                    <button type="reset" class="shadow-xl text-black truncate uppercase bg-orange-500 rounded-full lg:w-64 md:w-64 w-11/12 text-center p-3 my-2 hover:bg-orange-400">
                        <i class="fa-solid fa-rotate-right"></i><span> Reset Data</span>
                    </button>

                    <button onclick="location.href='{{ asset('settings/RFID') }}'" type="button" class="shadow-xl truncate text-white uppercase bg-red-500 hover:bg-red-400 lg:w-64 md:w-64 w-11/12 rounded-full text-center p-3 my-2">
                        <i class="fa-solid fa-ban"></i><span> Cancel</span>
                    </button>
                </div>
            </form>
        </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        var selected = document.getElementById('reader');
        var selectedIndex = selected.options[selected.selectedIndex].value;

        function changeSelected(){
            selectedIndex = selected.options[selected.selectedIndex].value;
        }
        function GetUID(){
            changeSelected()
            $.getJSON('http://192.168.200.1/getTag/'+selectedIndex, function(data) {
                var uid = `${data.uid}`
                document.getElementById("uid_i").value = uid;
		 document.getElementById("uid").value = uid;
            }).fail(function(){
                alert("reading was unsuccessful, please try again")
            });
        }
    </script>

@endsection
