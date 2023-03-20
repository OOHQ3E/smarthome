@extends('layouts.app')

@section('title') {{'Settings'}} @endsection

@section('content')

        <div class="p-5 text-center m-auto w-full flex gap-2">
            <a href="{{ asset('/') }}" >
                <button type="button" class="font-black text-left w-16 h-16 bg-gray-400 rounded-full text-center  py-3 px-3  hover:bg-gray-500">
                    ←
                </button>
            </a>
            <a href="{{ asset('create')}}/room" class="text-2xl text-black m-auto w-full">
                <div class="bg-green-500 text-white uppercase rounded-full py-3 px-6 transition hover:bg-green-400 hover:text-white ">
                    Add new room
                </div>
            </a>
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
                    <div><p class="text-left text-2xl font-light text-gray-100 py-3">{{$room->name}}</p>
                        <div class="bg-gray-100 rounded-lg overflow-auto m-3 bg-opacity-90">

                            <div class="flex flex-wrap gap-2 justify-center m-5">
                                <a href="{{ asset('create')}}/device/{{$room->id}}">
                                    <div class="my-1 bg-green-500 text-white uppercase rounded-full py-3 px-6 transition hover:bg-green-400 hover:text-white w-64 text-center">
                                        Add device
                                    </div>
                                </a>
                                <a href="/modify/room/{{ $room -> id }}">
                                    <div class="my-1 bg-yellow-500 text-white uppercase rounded-full py-3 px-6 transition hover:bg-yellow-400 hover:text-white w-64 text-center">
                                        Modify room
                                    </div>
                                </a>
                                <form action="/delete" method="POST">
                                    @csrf<button class="uppercase my-1 uppercase bg-red-500 text-white rounded-full py-3 px-6 transition hover:bg-red-400 hover:text-white w-64 text-center" name="id" type="submit" value="{{ $room -> id }}">Delete room</button>
                                </form>
                            </div>

                            <!--------------------------->
                            @forelse ($esps as $esp)
                                @if($esp->room_id === $room-> id)
                                    <table class="m-5 p-2 bg-gray-100 hover:bg-gray-200 bg-opacity-75 hover:bg-opacity-95 rounded-lg">
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
                                                <a href="/modify/device/{{$room->id}}/{{ $esp -> id }}">
                                                    <p class=" uppercase p-2 text-center rounded-lg bg-yellow-300 transition hover:bg-yellow-400"> Modify device</p>
                                                </a>
                                            <td class="p-2 m-1/3 text-white">
                                                <form action="device/delete/{{$esp->id}}" method="POST">
                                                    @csrf
                                                    {{method_field('DELETE')}}
                                                    <button class=" p-2 uppercase text-center rounded-lg bg-red-600 transition hover:bg-red-800"   name="id" type="submit" value="{{ $esp -> id }}">Delete device</button>
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


@endsection
