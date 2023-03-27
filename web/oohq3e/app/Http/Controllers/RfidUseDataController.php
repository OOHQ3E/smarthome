<?php

namespace App\Http\Controllers;

use App\Models\Esp;
use App\Models\RfidTag;
use App\Models\RfidUseData;
use Illuminate\Http\Request;

class RfidUseDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $useData = RfidUseData::all();
        $readers = Esp::where('type','RFID Reader')->get();
        $tags = RfidTag::all();
        return view('rfid.history',[
            'useData' => $useData,
            'readers' => $readers,
            'tags' => $tags
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
    public function store(Request $request){
        $reader = Esp::where('ip_End',$request->get("ipEnd","n/a"))->first();
        $tag = RfidTag::where('uid',$request->get('uid','n/a'))->first();
        if ($tag !== null){
            $data = new RfidUseData();
            $data->esp_id = $reader->id;
            $data->tag_id = $tag->id;
            $data->save();
            return 'OK';
        }else{
            return 'FAIL';
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RfidUseData  $rfidUseData
     * @return \Illuminate\Http\Response
     */
    public function show(RfidUseData $rfidUseData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RfidUseData  $rfidUseData
     * @return \Illuminate\Http\Response
     */
    public function edit(RfidUseData $rfidUseData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RfidUseData  $rfidUseData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RfidUseData $rfidUseData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RfidUseData  $rfidUseData
     * @return \Illuminate\Http\Response
     */
    public function destroy(RfidUseData $rfidUseData)
    {
        //
    }
}
