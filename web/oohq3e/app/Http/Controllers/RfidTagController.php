<?php

namespace App\Http\Controllers;

use App\Models\RfidTag;
use App\Models\Esp;
use Egulias\EmailValidator\Result\SpoofEmail;
use Illuminate\Http\Request;

class RfidTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('RFIDsettings');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $CardReaders = Esp::where('type','RFID Reader')->get();
        return view('rfid.create',[
            'CardReaders'=>$CardReaders
        ]);
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
     * @param  \App\Models\RfidTag  $rfidTag
     * @return \Illuminate\Http\Response
     */
    public function show(RfidTag $rfidTag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RfidTag  $rfidTag
     * @return \Illuminate\Http\Response
     */
    public function edit(RfidTag $rfidTag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RfidTag  $rfidTag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RfidTag $rfidTag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RfidTag  $rfidTag
     * @return \Illuminate\Http\Response
     */
    public function destroy(RfidTag $rfidTag)
    {
        //
    }
}
