<?php

namespace App\Http\Controllers;

use App\Models\espSensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class EspSensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tempData = espSensor::select(
            DB::raw("YEAR(created_at) as year"),
            DB::raw("MONTH(created_at) as month"),
            DB::raw("DAY(created_at) as day"),
            DB::raw("HOUR(created_at) as hour"),
            DB::raw("AVG(temperature) as avgTemp"),
            DB::raw("AVG(humidity) as avgHum")
        )   ->groupBy(DB::raw("1,2,3,4"))
            ->orderBy('year','desc')->orderBy('month','desc')->orderBy('day','desc')->orderBy('hour','desc')
            ->limit(24)
            ->pluck('avgTemp','hour')->reverse();

        $humData = espSensor::select(
            DB::raw("YEAR(created_at) as year"),
            DB::raw("MONTH(created_at) as month"),
            DB::raw("DAY(created_at) as day"),
            DB::raw("HOUR(created_at) as hour"),
            DB::raw("AVG(temperature) as avgTemp"),
            DB::raw("AVG(humidity) as avgHum")
        )   ->groupBy(DB::raw("1,2,3,4"))
            ->orderBy('year','desc')->orderBy('month','desc')->orderBy('day','desc')->orderBy('hour','desc')
            ->limit(24)
            ->pluck('avgHum','hour')->reverse();
        //$humData = array_slice($humData->values(),-24);
//select YEAR(created_at) as year,
// MONTH(created_at) as month,
// DAY(created_at) as day,
// HOUR(created_at) as hour,
// AVG(temperature) as avgTemp,
// AVG(humidity) as avgHum
// from esp_sensors
// GROUP BY 1,2,3,4;


        $templabels = $tempData->keys();
        $tempData = $tempData->values();

        $humlabels = $humData->keys();
        $humData = $humData->values();

        return view('chart', compact('templabels', 'tempData','humlabels','humData'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $esp = new espSensor();
        $esp->room = $request->get("room","n/a");
        $esp->temperature = $request->get("temp", "n/a");
        $esp->humidity = $request->get("hum", "n/a");
        $esp->save();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\espSensor  $espSensor
     * @return \Illuminate\Http\Response
     */
    public function show(espSensor $espSensor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\espSensor  $espSensor
     * @return \Illuminate\Http\Response
     */
    public function edit(espSensor $espSensor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\espSensor  $espSensor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, espSensor $espSensor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\espSensor  $espSensor
     * @return \Illuminate\Http\Response
     */
    public function destroy(espSensor $espSensor)
    {
        //
    }
    public function getStatus(){
            $response = Http::get("http://192.168.200.6/status");
            return $response;
        }
    public function getLatest()
    {
        return espSensor::latest()->first();
    }
}

