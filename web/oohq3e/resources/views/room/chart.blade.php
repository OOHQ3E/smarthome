@extends('layouts.app')

@section('title') {{'Chart Page'}} @endsection

@section('content')


<!DOCTYPE html>
<html>
@if(!empty($esps) )
    <head>
        <title>{{$roomData->name}}'s Sensor data chart</title>
    </head>

    <body>
    <div class="p-5 text-center m-auto w-full flex flex-wrap gap-4">
        <button class="lg:w-16 text-3xl md:w-full w-full h-16 text-gray-700 transition hover:text-gray-800 rounded-full font-black bg-gray-400 rounded-full hover:bg-gray-500"  onclick="location.href='{{ asset('/') }}'">
            <i class="fa-solid fa-arrow-left"></i>
        </button>

        <div class="my-4 text-center w-11/12 m-auto">
            <span class="text-3xl text-white font-sans py-2 uppercase font-light">
                {{$roomData->name}}'s temperature and humidity chart
            </span>
        </div>

    </div>
    <div class=" bg-white bg-opacity-75 shadow-2xl p-4 rounded-lg m-auto lg:w-3/4 sm:w-10/12 my-4">
        <canvas id="tempChart"></canvas>
    </div>

    <div class=" bg-white bg-opacity-75 shadow-2xl p-4 rounded-lg m-auto lg:w-3/4 sm:w-10/12 my-4">
        <canvas id="humChart" class="w-1/2"></canvas>
    </div>
    </body>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script type="text/javascript">
        var humlabels ={{ Js::from($humlabels) }};
        var tempslabels =  {{ Js::from($templabels) }};
        var temps =  {{ Js::from($tempData) }};
        var hums =  {{ Js::from($humData) }};


        const tempdata = {
            labels: tempslabels,
            datasets: [{
                label: 'Average temperature',
                backgroundColor: 'rgb(255,0,52)',
                borderColor: 'rgb(255,0,53)',
                data: temps,
                spanGaps: true
            }]
        };
        const humdata = {
            labels: humlabels,
            datasets: [{
                label: 'Average humidity',
                backgroundColor: 'rgb(0,177,255)',
                borderColor: 'rgb(0,177,255)',
                data: hums,
                spanGaps: true
            }]
        };


        const configtemp = {
            type: 'line',
            data: tempdata,
            options: {

                scales: {
                    y: { title:{display:true, text: "Average temperature"},
                        ticks: {
                            // Include °C after ticks
                            callback: function(value, index, ticks) {
                                return  value +"°C";
                            }
                        }
                    },
                    x: { title:{display:true, text: "Hour"},
                        ticks: {
                            // Include a :00 after tick
                            callback: function(value, index, ticks) {
                                return  this.getLabelForValue(value)+":00";
                            }
                        }
                    }
                }
            }
        };
        const confighum = {
            type: 'line',
            data: humdata,
            options:{
                scales: {
                    y: {
                        title:{display:true, text: "Average relative humidity"},
                        ticks: {
                            // Include % after ticks
                            callback: function(value, index, ticks) {
                                return  value +"%";
                            }
                        }
                    },
                    x: { title:{display:true, text: "Hour"},
                        ticks: {
                            // Include a :00 after tick
                            callback: function(value, index, ticks) {
                                return  this.getLabelForValue(value)+":00";
                            }
                        }
                    }
                }
            }
        };

        const tempChart = new Chart(
            document.getElementById('tempChart'),
            configtemp
        );
        const humChart = new Chart(
            document.getElementById('humChart'),
            confighum
        );

    </script>
@else
    <h2>FUCK</h2>
@endif
</html>
