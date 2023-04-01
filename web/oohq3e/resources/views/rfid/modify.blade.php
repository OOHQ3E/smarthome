@extends('layouts.app')

@section('title') {{'Modify RFID Tag'}} @endsection

@section('content')
    <head>
        <title>Modify RFID Tag</title>
    </head>
    <div class="m-auto w-1/2 py-2">
        <div class="text-center">
            <h1 class="text-3xl text-white font-sans pb-2 mt-2 uppercase font-light">
                Modify RFID Tag</span>
            </h1>
        </div>
    </div>

    @if(session()->has('error') || $errors->any())
        <ul class="shadow-2xl bg-red-600 rounded-lg w-1/3 m-auto text-xl text-center text-white font-sans py-2 my-2 font-light">
            <li>
                {{ session()->get('error') }}
            </li>
            @foreach ($errors->all() as $error)
                <li id="error_message">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="m-auto text-center">
        <form action="/modify/RFID/{{$reader->id}}/{{$tag->id}}" method="POST" class="shadow-2xl lg:w-2/3 m-auto px-10 py-5 bg-gray-100 rounded-lg form-input">
            @csrf

            <div class="text-left w-11/12 m-auto">
                <label for="name" class="lg:my-3 md:my-3 my-1 font-semibold text-left">Tag name:</label>
                <input type="text" class="truncate ... pl-2 my-6 w-full text-xl rounded-md" id="name" name="name" class="rounded" value="{{$tag->name}}" required>
                <label for="reader" class="lg:my-3 md:my-3 my-1 font-semibold text-left">Reader name:</label>
                <select name="reader" id="reader" class="my-5 text-xl w-full m-auto rounded-md">
                    @foreach($readers as $r)
                        @if($r->id == $tag->esp_id)
                            <option selected value="{{$r->id}}">{{$r->name}}</option>
                        @else
                            <option  value="{{$r->id}}">{{$r->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>


            <div class="text-center flex lg:flex-nowrap md:flex-nowrap flex-wrap w-11/12 m-auto">
                <label for="uid" class="lg:my-6 md:my-3 my-1 p-2 font-semibold text-left">UID: </label>
                <input type="hidden" name="uid" id="uid" value="{{$tag->uid}}">
                <input disabled type="text" class="truncate ... pl-2 lg:my-6 md:my-3 my-1 w-full text-xl rounded-md" id="uid_i" name="uid_i" class="rounded" value="{{$tag->uid}}" required>

                <button type="button" onclick="GetUID()" id="tagRead" class="shadow-xl truncate m-auto uppercase bg-cyan-600 lg:ml-2 md:ml-2 m-auto rounded-full lg:w-64 my-6 md:w-64 w-11/12 text-center lg:my-3 md:my-3 my-1 p-3 hover:bg-cyan-500">
                    <i class="fa-solid fa-id-card-clip"></i><span> Read Tag</span>
                </button>
                <span hidden id="notice" class="font-semibold m-1 m-auto text-left py-3" >Please touch tag on reader!</span>
            </div>
            <div class="text-gray-50 flex flex-wrap justify-center gap-2">
                <button id="submit" type="submit" class="shadow-xl truncate uppercase bg-green-500 rounded-full lg:w-64 md:w-64 w-11/12 text-center p-3 my-2 hover:bg-green-400">
                    <i class="fa-solid fa-plus"></i><span> Apply Changes</span>
                </button>

                <button id="reset" type="reset" class="shadow-xl text-black truncate uppercase bg-orange-500 rounded-full lg:w-64 md:w-64 w-11/12 text-center p-3 my-2 hover:bg-orange-400">
                    <i class="fa-solid fa-rotate-right"></i><span> Reset Data</span>
                </button>

                <button id="cancel" onclick="location.href='{{ asset('settings/RFID') }}'" type="button" class="shadow-xl truncate text-white uppercase bg-red-500 hover:bg-red-400 lg:w-64 md:w-64 w-11/12 rounded-full text-center p-3 my-2">
                    <i class="fa-solid fa-ban"></i><span> Cancel</span>
                </button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        var selected = document.getElementById('reader');
        var ReaderID = selected.options[selected.selectedIndex].value;

        function changeSelected(){
            ReaderID = selected.options[selected.selectedIndex].value;
            console.log(ReaderID);
        }
        function GetUID(){
            document.getElementById("notice").hidden = false;
            changeSelected()
            $.getJSON('http://192.168.200.1/getTag/'+ReaderID, function(data) {
                var uid = `${data.uid}`
                document.getElementById("uid_i").value = uid;
                document.getElementById("uid").value = uid;
                document.getElementById("notice").hidden = true;
            }).fail(function(){
                alert("reading was unsuccessful, please try again")
                document.getElementById("notice").hidden = true;
            });
        }
    </script>

@endsection
