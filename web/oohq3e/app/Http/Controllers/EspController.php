<?php

namespace App\Http\Controllers;
use App\Models\Esp;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class EspController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();
        $esps = Esp::all();

        //dd($esps,$rooms);

        return view('settings',[
            'rooms' => $rooms,
            'esps' => $esps
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Esp  $esp
     * @return \Illuminate\Http\Response
     */
    public function show(Esp $esp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Esp  $esp
     * @return \Illuminate\Http\Response
     */
    public function edit(Esp $esp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Esp  $esp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Esp $esp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Esp  $esp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Esp $esp)
    {
        //
    }

    public function getStatus($esp){
        $response = json_decode(Http::get("http://192.168.200.".$esp."/status"));
        return response()->json($response);
    }

    public function Toggle($esp,$status){
        $response = json_decode(Http::get("http://192.168.200.".$esp."/".$status));
        return response()->json($response);
    }
}
