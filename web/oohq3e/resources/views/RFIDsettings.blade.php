@extends('layouts.app')

@section('title') {{'RFID Settings'}} @endsection

@section('content')

    <div id="back_to_settings" class="m-auto flex lg:flex-nowrap md:flex-nowrap flex-wrap gap-3 p-4 text-center w-full">
        <button class="shadow-2xl lg:w-16 md:w-16 w-full h-16 text-3xl text-white rounded-full text-gray-700 transition hover:text-gray-800 bg-gray-400 rounded-full hover:bg-gray-500"  onclick="location.href='{{ asset('/settings/') }}'">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <button id="rfid_use_history" class="m-auto text-xl shadow-xl bg-orange-500 text-white uppercase rounded-full transition hover:bg-orange-600 hover:text-black h-16 lg:w-11/12 md:w-4/5 w-full text-center" onclick="location.href='/RFID/history'">
            <i class="fa-solid fa-clock-rotate-left"></i> RFID Use History</span>
        </button>
    </div>


    @if (Session::has('error'))
        <div class="shadow-2xl bg-red-600 rounded-lg w-2/3 m-auto text-xl text-center font-sans py-2 my-2">
                <span id="error_message" class="px-5 text-2xl text-gray-100 font-semibold">{{Session::get('error')}}</span>
        </div>
    @endif

    @if (Session::has('message'))
          <div class="flex justify-center font-sans text-center my-2">
                <div class="w-full">
                    <div id="message" class="px-5 text-2xl text-gray-100 font-light">{{ Session::get('message')}}</div>
                </div>
            </div>
    @endif
    <div class="p-2">
        <div class="p-3 lg:max-w-3/12 md:max-w-10/12 sm:max-w-11/12 grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 inline-block">
            @forelse ($readers as $reader)
                <div>
                    <p id="reader_name" class="text-left text-3xl font-semibold text-gray-100 py-3">{{$reader->name}}</p>
                    <div class="bg-gray-100 shadow-2xl rounded-lg overflow-auto m-3 bg-opacity-90">

                   <div class="flex flex-wrap gap-2 justify-center m-5">
                       <button id="add_tag_{{$reader->name}}" onclick="location.href='{{ asset('create')}}/RFID/{{$reader->id}}'" class="shadow-xl my-1 bg-green-500 text-white uppercase rounded-full py-3 px-6 transition hover:bg-green-600 hover:text-black w-64 text-center">
                           <i class="fa-solid fa-plus"></i><span> Add RFID tag</span>
                       </button>
                   </div>
                        <!--------------------------->
                        @forelse ($tags as $tag)
                            @if($tag->esp_id === $reader-> id)
                                <table class="shadow-xl m-5 p-2 bg-gray-100 hover:bg-gray-200 hover:border-gray-400 bg-opacity-75 hover:bg-opacity-95 rounded-lg">
                                    <thead class="text-center">
                                    <td class="w-5/6"></td>
                                    <td class="w-1/3"></td>
                                    <td class="w-1/3"></td>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td class="p-3 m-1/3">
                                            <ul class="m-1">
                                                <li id="tag_name_{{$tag->name}}" class="leading-normal"><span class=" font-bold">Name:</span> {{ $tag->name }} </li>
                                                <br>
                                                <li id="tag_uid_{{$tag->name}}" class="leading-normal"><span class="font-bold">UID:</span> {{ $tag->uid }} </li>
                                                <br>
                                                <li id="tag_date_add_{{$tag->name}}" class="leading-normal"><span class="font-bold">Date Added: </span><span class="font-semibold">{{ $tag->created_at }}</span></li>
                                                <br>
                                                <li id="tag_date_mod_{{$tag->name}}"  class="leading-normal"><span class="font-bold">Date Last modified: </span><span class="font-semibold">{{ $tag->updated_at }}</span></li>
                                            </ul>
                                        </td>

                                        <td class="p-2 m-1/3">
                                            <button id="modify_tag_{{$tag->name}}" class="shadow-xl w-14 h-14 rounded-lg bg-yellow-300 transition hover:bg-yellow-400 uppercase" onclick="location.href='/modify/RFID/{{$reader->id}}/{{$tag->id}}'">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                        </td>
                                        <td class="p-2 m-1/3 text-white">
                                            <form action="/delete/tag/{{$tag->name}}" method="POST">
                                                @csrf
                                                {{method_field('DELETE')}}
                                                <button id="delete_tag_{{$tag->name}}" class="shadow-xl w-14 h-14 uppercase text-center rounded-lg bg-red-500 transition hover:bg-red-800" name="id" type="submit" value="{{ $tag -> id }}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            @endif
                        @empty
                        @endforelse
                    </div></div>
            @empty

                <div id="no_rfid_message" class="flex justify-center font-sans font-bold text-2xl text-black">
                    <h1>No RFID reader in the database!</h1>
                </div>

            @endforelse


        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        document.onsubmit = function(){
            return confirm('Are you sure you want to delete it? This action cannot be undone.');
        }
    </script>
@endsection
