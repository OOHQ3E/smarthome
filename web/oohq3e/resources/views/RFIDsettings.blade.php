@extends('layouts.app')

@section('title') {{'RFID Settings'}} @endsection

@section('content')

    <div class="m-auto flex lg:flex-nowrap md:flex-nowrap flex-wrap gap-3 p-4 text-center w-full">
        <button class="shadow-2xl lg:w-16 md:w-16 w-full h-16 text-3xl text-white rounded-full text-gray-700 transition hover:text-gray-800 bg-gray-400 rounded-full hover:bg-gray-500"  onclick="location.href='{{ asset('/settings/') }}'">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <button onclick="location.href='{{ asset('create')}}/RFID'" class="text-xl m-auto text-center lg:w-2/5 md:w-2/5 w-full rounded-full shadow-2xl bg-green-500 text-white uppercase rounded-full h-16 transition hover:bg-green-600 hover:text-black ">
            <i class="fa-solid fa-plus"></i><span> Add RFID tag</span>
        </button>
        <button class="m-auto text-xl shadow-xl bg-orange-500 text-white uppercase rounded-full transition hover:bg-orange-600 hover:text-black h-16 lg:w-2/5 md:w-2/5 w-full text-center" onclick="location.href='/settings/{{ asset('state')}}/RFID/security'">
            <i class="fa-solid fa-clock-rotate-left"></i> Use History</span>
        </button>
    </div>


    @if (Session::has('error'))
        <div class="shadow-2xl bg-red-600 rounded-lg w-2/3 m-auto text-xl text-center font-sans py-2 my-2">
                <span class="px-5 text-2xl text-gray-100 font-semibold">{{Session::get('error')}}</span>
        </div>
    @endif

    <div class="p-2">
        <div class="p-3 w-11/12 grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 inline-block m-auto">
{{--           @forelse ($RFIDs as $rfid)--}}
                <div>
                    <p class="text-left text-3xl font-semibold text-gray-100 py-3">{{--{{$rfid->name}}--}}</p>

                    <div class="bg-gray-100 shadow-2xl rounded-lg overflow-auto m-3 bg-opacity-90">
                        <div class="flex flex-wrap gap-2 justify-center m-5">
                        </div>

                        <!--------------------------->
{{--                        @forelse ($esps as $esp)--}}
{{--                            @if($esp->room_id === $room-> id)--}}
                                <table class="shadow-xl m-5 p-2 bg-gray-100 hover:bg-gray-200 hover:border-gray-400 bg-opacity-75 hover:bg-opacity-95 rounded-lg">

                                    <td class="w-5/6"></td>
                                    <td class="w-1/3"></td>
                                    <td class="w-1/3"></td>

                                    <tbody>
                                    <tr>
                                        <td class="p-3 m-1/3">
                                            <ul class="m-1">
                                                <li class="leading-normal"><span class=" font-bold">Name:</span> Ms. Kayla Smith {{--{{ $esp->name }}--}} </li>
                                                <br>
                                                <li class="leading-normal"><span class="font-bold">Date Added:</span> 2023.02.23 13:15 {{--{{ $esp->type }}--}} </li>
                                                <br>
                                                <li class="leading-normal"><span class="font-bold">ID:</span> <span class="">asddy316asd{{--{{ $esp->ip_End }}--}}</span></li>
                                            </ul>
                                        </td>

                                        <td class="p-2 m-1/3">
                                            <button class="shadow-xl w-14 h-14 rounded-lg bg-yellow-300 transition hover:bg-yellow-400 uppercase" onclick="location.href='/modify/device/{{--{{$room->id}}/{{ $esp -> id }}--}}'">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                        </td>
                                        <td class="p-2 m-1/3 text-white">
                                            <form action="device/delete/{{--{{$esp->id}}--}}" method="POST">
                                                @csrf
                                                {{method_field('DELETE')}}
                                                <button class="shadow-xl w-14 h-14 uppercase text-center rounded-lg bg-red-500 transition hover:bg-red-800" name="id" type="submit" value="{{--{{ $esp -> id }}--}}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
{{--                            @endif--}}
{{--                        @empty--}}
{{--                        @endforelse--}}
                    </div>
                </div>
{{--            --}}

            <div>
                <p class="text-left text-3xl font-semibold text-gray-100 py-3">{{--{{$rfid->name}}--}}</p>

                <div class="bg-gray-100 shadow-2xl rounded-lg overflow-auto m-3 bg-opacity-90">
                    <div class="flex flex-wrap gap-2 justify-center m-5">
                    </div>

                    <!--------------------------->
                    {{--                        @forelse ($esps as $esp)--}}
                    {{--                            @if($esp->room_id === $room-> id)--}}
                    <table class="shadow-xl m-5 p-2 bg-gray-100 hover:bg-gray-200 hover:border-gray-400 bg-opacity-75 hover:bg-opacity-95 rounded-lg">

                        <td class="w-5/6"></td>
                        <td class="w-1/3"></td>
                        <td class="w-1/3"></td>

                        <tbody>
                        <tr>
                            <td class="p-3 m-1/3">
                                <ul class="m-1">
                                    <li class="leading-normal"><span class=" font-bold">Name:</span> Mr. Paul Saint {{--{{ $esp->name }}--}} </li>
                                    <br>
                                    <li class="leading-normal"><span class="font-bold">Date Added:</span> 2023.02.23 13:19{{--{{ $esp->type }}--}} </li>
                                    <br>
                                    <li class="leading-normal"><span class="font-bold">ID:</span> <span class="">sdgsdg562{{--{{ $esp->ip_End }}--}}</span></li>
                                </ul>
                            </td>

                            <td class="p-2 m-1/3">
                                <button class="shadow-xl w-14 h-14 rounded-lg bg-yellow-300 transition hover:bg-yellow-400 uppercase" onclick="location.href='/modify/device/{{--{{$room->id}}/{{ $esp -> id }}--}}'">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                            </td>
                            <td class="p-2 m-1/3 text-white">
                                <form action="device/delete/{{--{{$esp->id}}--}}" method="POST">
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <button class="shadow-xl w-14 h-14 uppercase text-center rounded-lg bg-red-500 transition hover:bg-red-800" name="id" type="submit" value="{{--{{ $esp -> id }}--}}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    {{--                            @endif--}}
                    {{--                        @empty--}}
                    {{--                        @endforelse--}}
                </div>
            </div>
            <div>
                <p class="text-left text-3xl font-semibold text-gray-100 py-3">{{--{{$rfid->name}}--}}</p>

                <div class="bg-gray-100 shadow-2xl rounded-lg overflow-auto m-3 bg-opacity-90">
                    <div class="flex flex-wrap gap-2 justify-center m-5">
                    </div>

                    <!--------------------------->
                    {{--                        @forelse ($esps as $esp)--}}
                    {{--                            @if($esp->room_id === $room-> id)--}}
                    <table class="shadow-xl m-5 p-2 bg-gray-100 hover:bg-gray-200 hover:border-gray-400 bg-opacity-75 hover:bg-opacity-95 rounded-lg">

                        <td class="w-5/6"></td>
                        <td class="w-1/3"></td>
                        <td class="w-1/3"></td>

                        <tbody>
                        <tr>
                            <td class="p-3 m-1/3">
                                <ul class="m-1">
                                    <li class="leading-normal"><span class=" font-bold">Name:</span> Ms. Rhoda Smith {{--{{ $esp->name }}--}} </li>
                                    <br>
                                    <li class="leading-normal"><span class="font-bold">Date Added:</span>  2023.02.23 13:20{{--{{ $esp->type }}--}} </li>
                                    <br>
                                    <li class="leading-normal"><span class="font-bold">ID:</span> <span class="">9746s1dgsdg{{--{{ $esp->ip_End }}--}}</span></li>
                                </ul>
                            </td>

                            <td class="p-2 m-1/3">
                                <button class="shadow-xl w-14 h-14 rounded-lg bg-yellow-300 transition hover:bg-yellow-400 uppercase" onclick="location.href='/modify/device/{{--{{$room->id}}/{{ $esp -> id }}--}}'">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                            </td>
                            <td class="p-2 m-1/3 text-white">
                                <form action="device/delete/{{--{{$esp->id}}--}}" method="POST">
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <button class="shadow-xl w-14 h-14 uppercase text-center rounded-lg bg-red-500 transition hover:bg-red-800" name="id" type="submit" value="{{--{{ $esp -> id }}--}}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    {{--                            @endif--}}
                    {{--                        @empty--}}
                    {{--                        @endforelse--}}
                </div>
            </div>

{{--            --}}
{{--            @empty--}}


{{--                <div class="flex justify-center font-sans font-bold text-2xl text-black">--}}
{{--                    <h1>No room in the database!</h1>--}}
{{--                </div>--}}


{{--            @endforelse--}}


        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        document.onsubmit = function(){
            return confirm('Are you sure you want to delete it? This action cannot be undone.');
        }
    </script>
@endsection
