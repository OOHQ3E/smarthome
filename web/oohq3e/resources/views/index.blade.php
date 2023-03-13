@extends('layouts.app')

@section('title') {{'Index Page'}} @endsection

@section('content')

    <!--TODO: with sm-my it doesn't want to work for whatever reason -->
    <div class=" bg-white bg-opacity-75 shadow-2xl p-4 rounded-lg m-auto lg:w-3/4 sm:w-10/12 lg:my-4 md:my-6 sm:my-8">
        <h2 class="text-left m-2 bold">Room 1</h2>
       <div class="flex flex-wrap gap-4 justify-center">
           <a href="{{ asset('chart') }}">
               <div class="bg-opacity-75 bg-gray-400 p-4 rounded-lg">
                    <p id="espData">
                        <!--Temperature: 30°C<br> Humidity: 70% -->
                    </p>
                </div>
           </a>
           <div class="bg-opacity-75 bg-gray-400 p-4 rounded-lg">
               <label for="large-toggle1" class="inline-flex relative items-center cursor-pointer">
                   <input type="checkbox" value="" id="large-toggle1" class="sr-only peer">
                   <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                   <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-800">Toggle 1</span>
               </label>
           </div>

           <div class="bg-opacity-75 bg-gray-400 p-4 rounded-lg">
               <label for="large-toggle2" class="inline-flex relative items-center cursor-pointer">
                   <input type="checkbox" value="" id="large-toggle2" class="sr-only peer">
                   <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                   <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-800">Toggle 2</span>
               </label>
           </div>
           <div class="bg-opacity-75 bg-gray-400 p-4 rounded-lg">
               <label for="large-toggle3" class="inline-flex relative items-center cursor-pointer">
                   <input type="checkbox" value="" id="large-toggle3" class="sr-only peer">
                   <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                   <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-800">Toggle 3</span>
               </label>
           </div>
       </div>

    </div>
    <div class=" bg-white bg-opacity-75 shadow-2xl p-4 rounded-lg m-auto lg:w-3/4 sm:w-10/12 lg:my-4 md:my-6 sm:my-8">
        <div class="flex flex-wrap gap-4 justify-center">

            <div class="bg-opacity-75 bg-gray-400 p-4 rounded-lg">
                <label for="large-toggle4" class="inline-flex relative items-center cursor-pointer">
                    <input type="checkbox" value="" id="large-toggle4" class="sr-only peer">
                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-800">Toggle 4</span>
                </label>
            </div>

            <div class="bg-opacity-75 bg-gray-400 p-4 rounded-lg">
                <label for="large-toggle5" class="inline-flex relative items-center cursor-pointer">
                    <input type="checkbox" value="" id="large-toggle5" class="sr-only peer">
                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-800">Toggle 5</span>
                </label>
            </div>
            <div class="bg-opacity-75 bg-gray-400 p-4 rounded-lg">
                <label for="large-toggle6" class="inline-flex relative items-center cursor-pointer">
                    <input type="checkbox" value="" id="large-toggle6" class="sr-only peer">
                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-800">Toggle 6</span>
                </label>
            </div>
        </div>

    </div>
 <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
 <script>
	getLatest();
        setInterval(getLatest, 10000)
       function getLatest(){
           $.getJSON('http://192.168.200.1/getLatest', function(data) {
               var text = `Temperature: ${data.temperature}°C<br> Humidity: ${data.humidity}%`
            document.getElementById("espData").innerHTML = text;
	});
       }

    </script>

