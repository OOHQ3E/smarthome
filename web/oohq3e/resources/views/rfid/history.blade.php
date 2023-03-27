@extends('layouts.app')

@section('title') {{'RFID use history'}} @endsection

@section('content')
    <!DOCTYPE html>
<head>
    <title>RFID use history</title>
</head>
<html>
<div class="p-5 text-center m-auto w-full flex flex-wrap gap-4">
    <button class="shadow-2xl lg:w-16 text-3xl md:w-full w-full h-16 text-gray-700 transition hover:text-gray-800 rounded-full font-black bg-gray-400 rounded-full hover:bg-gray-500"  onclick="location.href='{{ asset('/') }}'">
        <i class="fa-solid fa-arrow-left"></i>
    </button>

    <div class="my-4 text-center w-11/12 m-auto">
        <h1 class="text-3xl text-white font-sans py-2 uppercase font-light">
            RFID use history
        </h1>
    </div>

</div>
<div class="m-auto bg-opacity-75 shadow-2xl bg-white rounded-md lg:w-10/12 w-full my-3 p-3 text-center overflow-auto">
        @forelse ($readers as $reader)
            <div class="w-11/12 m-2 p-2 text-left">
                <span class="text-black font-semibold text-xl">{{$reader->name}}'s read history</span>
            </div>
                <table class="w-11/12 m-auto text-left bg-white rounded-lg overflow-hidden shadow-2xl my-5 ">
                    <thead>
                    <tr class="bg-cyan-600 text-black  rounded-lg mb-2 lg:mb-0">
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
        <span>Database has no use value!</span>
        @endforelse


</div>
