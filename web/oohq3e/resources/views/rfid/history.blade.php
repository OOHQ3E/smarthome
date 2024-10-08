@extends('layouts.app')

@section('title') {{'RFID use history'}} @endsection

@section('content')
<head>
    <title>RFID Use History</title>
</head>
<html>
<div class="m-auto flex lg:flex-nowrap md:flex-nowrap flex-wrap gap-3 p-4 text-center w-full">
    <button id="back_to_rfid_settings" class="shadow-2xl lg:w-16 text-3xl md:w-full w-full h-16 text-gray-700 transition hover:text-gray-800 rounded-full font-black bg-gray-400 rounded-full hover:bg-gray-500"  onclick="location.href='{{ asset('/settings/RFID/') }}'">
        <i class="fa-solid fa-arrow-left"></i>
    </button>

    <div class="my-4 text-center w-11/12 m-auto">
        <h1 class="text-3xl text-white font-sans py-2 uppercase font-light">
            RFID Use History
        </h1>
    </div>

</div>
<div class="m-auto bg-opacity-75 shadow-2xl bg-white rounded-md lg:w-10/12 w-full my-3 p-3 text-center overflow-auto">
        @forelse ($readers as $reader)
            <div class="w-11/12 m-2 p-2 text-left">
                <span class="text-black font-semibold text-xl">{{$reader->name}}'s read history</span>
            </div>
                <table class="w-11/12 m-auto text-left bg-white rounded-lg overflow-hidden shadow-2xl my-5">
                    <thead>
                    <tr class="bg-cyan-600 text-black mb-2 lg:mb-0">
                        <th class="p-2 text-left break-words w-3 text-center">Ordinal number</th>
                        <th class="p-2 text-left break-words w-3">Tag uid</th>
                        <th class="p-2 text-left break-words">Tag name</th>
                        <th class="p-2 text-left break-words">Date used</th>
                    </tr>
                    </thead>
                <?php $index = 1; ?>

                @forelse ($useData as $data)
                    <?php $uid = ""; $name = ""; ?>
                       @foreach($tags as $tag)
                            @if($reader->id == $data->esp_id && $tag->id == $data->tag_id)
                                <?php $uid = $tag-> uid;$name = $tag->name;?>
                                @break
                            @endif
                        @endforeach
                        @if($uid != "")
                               <tr class="mb-2 lg:mb-0">
                                   <td class="break-words text-center border-grey-light border hover:bg-gray-100 hover:bg-opacity-95 px-1 py-3 truncate ... h-12">{{$index++}}</td>
                                   <td class="break-words border-grey-light border hover:bg-gray-100 hover:bg-opacity-95 px-1 py-3 h-12">{{ $uid }}</td>
                                   <td class="break-words border-grey-light border hover:bg-gray-100 hover:bg-opacity-95 px-1 py-3 h-12">{{ $name  }}</td>
                                   <td class="break-words border-grey-light border hover:bg-gray-100 hover:bg-opacity-95 px-1 py-3 h-12">{{ $data->created_at }}</td>
                               </tr>
                        @endif

                @empty

                @endforelse
        </table>
        @empty
        <p id="no_room_message" class="text-center font-bold m-2 text-xl">There is no RFID use history in the database!</p>
        @endforelse
</div>
