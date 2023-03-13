@extends('layouts.app')

@section('title') {{'Chart Page'}} @endsection

@section('content')


    <!DOCTYPE html>
<html>
<head>
    <title>Laravel 9 ChartJS Chart Example - ItSolutionStuff.com</title>
</head>

<body>
<div class=" bg-white bg-opacity-75 shadow-2xl p-4 rounded-lg m-auto lg:w-3/4 sm:w-10/12 lg:my-4 md:my-6 sm:my-8">
<canvas id="tempChart" height="100px"></canvas>
</div>

<div class=" bg-white bg-opacity-75 shadow-2xl p-4 rounded-lg m-auto lg:w-3/4 sm:w-10/12 lg:my-4 md:my-6 sm:my-8">
    <canvas id="humChart" height="100px"></canvas>
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
