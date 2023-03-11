<?php

namespace App\Http\Controllers;

use App\Models\espSensor;
use Illuminate\Http\Request;

class EspSensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store( $room,$temperature,$humidity)
    {
       
        $esp = new espSensor();
        $esp->room = $room;
        $esp->temperature = $temperature;
        $esp->humidity = $humidity;
        $esp->save();
        return with("success");
        dd($request->room);
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
}
