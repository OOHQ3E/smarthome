<?php

namespace App\Http\Controllers;

use App\Models\RfidTag;
use App\Models\Esp;
use Egulias\EmailValidator\Result\SpoofEmail;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class RfidTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $esps = Esp::where('type','RFID Reader')->get();
        $tags = RfidTag::all();

        return view('RFIDsettings',[
            'esps' => $esps,
            'tags' => $tags
           ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $CardReaders = DB::table('esp')->select('*')->where('type','=','RFID Reader')->get();
      
        if (count($CardReaders) == 0){
            $error = 'You need to add an RFID reader first!';
            return redirect()->back()->with(['error'=> $error]);
        }
        else{
            return view('rfid.create',[
                'CardReaders' => $CardReaders
            ]);
        }
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
