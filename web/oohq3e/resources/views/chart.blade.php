@extends('layouts.app')

@section('title') {{'Chart Page'}} @endsection

@section('content')


<!DOCTYPE html>
<html>
<head>
    <title>Room 1 Sensor data chart</title>
</head>

<body>
<div class="m-auto lg:w-3/4 sm:w-10/12 py-2">  
    <div class="text-center">
            <h1 class="text-2xl text-white font-sans pb-5 uppercase font-light">
                Room 1 temperature and humidity chart
            </h1>
    </div>
</div>
<body>
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
        options: {}
    };
    const confighum = {
        type: 'line',
        data: humdata,
        options: {}
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
</html>
