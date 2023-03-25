@extends('layouts.app')

@section('title') {{'Settings'}} @endsection

@section('content')

        <div class="m-auto flex md:flex-nowrap sm:flex-nowrap flex-wrap gap-3 p-4 text-center justify-center">
            <button class="shadow-2xl lg:w-16 md:w-16 w-full h-16 text-3xl text-white rounded-full text-gray-700 transition hover:text-gray-800 bg-gray-400 rounded-full hover:bg-gray-500"  onclick="location.href='{{ asset('/') }}'">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <button onclick="location.href='{{ asset('create')}}/room'" class="text-xl m-auto lg:w-64 md:w-64 w-full rounded-full shadow-2xl bg-green-500 text-white uppercase rounded-full py-3 px-6 h-16 transition hover:bg-green-600 hover:text-black ">
                <i class="fa-solid fa-plus"></i><span> Add Room</span>
            </button>
            <button class="shadow-2xl  h-16 text-xl text-white rounded-full text-gray-700 lg:w-3/4 md:w-96 w-full transition hover:text-gray-800 bg-gray-400 rounded-full hover:bg-gray-500"  onclick="location.href='{{ asset('settings/RFID') }}'">
                <i class="fa-solid fa-key"></i> <span>RFID settings</span>
            </button>


        </div>
        @if (Session::has('message'))
            <div class="flex justify-center font-sans text-center my-2">
                <div class="w-full">
                    <div class="px-5 text-2xl text-gray-100 font-light">{{ Session::get('message') }}</div>
                </div>
            </div>
        @endif

        <div class="p-2">
            <div class="p-3 lg:max-w-3/12 md:max-w-10/12 sm:max-w-11/12 grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 inline-block">
                @forelse ($rooms as $room)
                    <div>
                        <p class="text-left text-3xl font-semibold text-gray-100 py-3">{{$room->name}}</p>

                        <div class="bg-gray-100 shadow-2xl rounded-lg overflow-auto m-3 bg-opacity-90">
                            <div class="flex flex-wrap gap-2 justify-center m-5">
                                <button onclick="location.href='{{ asset('create')}}/device/{{$room->id}}'">
                                    <div class="shadow-xl my-1 bg-green-500 text-white uppercase rounded-full py-3 px-6 transition hover:bg-green-600 hover:text-white w-64 text-center">
                                        <i class="fa-solid fa-plus"></i><span> Add device</span>
                                    </div>
                                </button>
                                <button onclick="location.href='/modify/room/{{ $room -> id }}'">
                                    <div class="shadow-xl my-1 text-black uppercase rounded-full py-3 px-6 bg-yellow-300 transition hover:bg-yellow-400 w-64 text-center">
                                        <i class="fa-regular fa-pen-to-square"></i><span> Modify Room</span>
                                    </div>
                                </button>
                                <form action="/delete/{{$room->id}}" method="POST">
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <button class="shadow-xl uppercase my-1 uppercase bg-red-500 text-white rounded-full py-3 px-6 transition hover:bg-red-800 hover:text-white w-64 text-center" name="id" type="submit" value="{{ $room -> id }}">
                                        <i class="fa-solid fa-trash-can"></i><span> Delete room</span>
                                    </button>
                                </form>
                            </div>

                            <!--------------------------->
                            @forelse ($esps as $esp)
                                @if($esp->room_id === $room-> id)
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
                                                    <li class="leading-normal"><span class=" font-bold">Name:</span> {{ $esp->name }} </li>
                                                    <br>
                                                    <li class="leading-normal"><span class="font-bold">Type:</span> {{ $esp->type }} </li>
                                                    <br>
                                                    <li class="leading-normal"><span class="font-bold">IP:</span> 192.168.200.<span class="font-semibold">{{ $esp->ip_End }}</span></li>
                                                </ul>
                                            </td>

                                            <td class="p-2 m-1/3">
                                                <button class="shadow-xl w-14 h-14 rounded-lg bg-yellow-300 transition hover:bg-yellow-400 uppercase" onclick="location.href='/modify/device/{{$room->id}}/{{ $esp -> id }}'">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                            </td>
                                            <td class="p-2 m-1/3 text-white">
                                                <form action="device/delete/{{$esp->id}}" method="POST">
                                                    @csrf
                                                    {{method_field('DELETE')}}
                                                    <button class="shadow-xl w-14 h-14 uppercase text-center rounded-lg bg-red-500 transition hover:bg-red-800" name="id" type="submit" value="{{ $esp -> id }}">
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

                            <div class="flex justify-center font-sans font-bold text-2xl text-black">
                                <h1>No room in the database!</h1>
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
