<?php

namespace App\Http\Controllers;

use App\Models\Esp;
use App\Models\EspSensorData;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class EspSensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($room)
    {
        $roomData = Room::find($room);
        $esps = DB::table('esp')->where("room_id","=", $room)->where("type","=","Sensor")->first();

        if ($esps == null){
            return app(RoomController::class)->index();
        }
        else
        {
            $tempData = EspSensorData::select(
                DB::raw("YEAR(created_at) as year"),
                DB::raw("MONTH(created_at) as month"),
                DB::raw("DAY(created_at) as day"),
                DB::raw("HOUR(created_at) as hour"),
                DB::raw("AVG(temperature) as avgTemp")
            )->where("room_id",$room)->groupBy(DB::raw("1,2,3,4"))
                ->orderBy('year','desc')->orderBy('month','desc')->orderBy('day','desc')->orderBy('hour','desc')
                ->limit(24)
                ->pluck('avgTemp','hour')->reverse();

            $humData = EspSensorData::select(
                DB::raw("YEAR(created_at) as year"),
                DB::raw("MONTH(created_at) as month"),
                DB::raw("DAY(created_at) as day"),
                DB::raw("HOUR(created_at) as hour"),
                DB::raw("AVG(humidity) as avgHum")
            ) ->where("room_id",$room)->groupBy(DB::raw("1,2,3,4"))
                ->orderBy('year','desc')->orderBy('month','desc')->orderBy('day','desc')->orderBy('hour','desc')
                ->limit(24)
                ->pluck('avgHum','hour')->reverse();

            $templabels = $tempData->keys();
            $tempData = $tempData->values();

            $humlabels = $humData->keys();
            $humData = $humData->values();

            return view('room.chart',compact('templabels', 'tempData','humlabels','humData','roomData', 'esps'));
        }
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
        $device = Esp::where('ip_End',"=",$request->get("ipEnd","n/a"))->first();

        $esp = new EspSensorData();
        $esp->room_id = $device->room_id;
        $esp->temperature = $request->get("temp", "n/a");
        $esp->humidity = $request->get("hum", "n/a");
        $esp->save();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EspSensorData  $EspSensorData
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('RFIDsettings');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EspSensorData  $EspSensorData
     * @return \Illuminate\Http\Response
     */
    public function edit(EspSensorData $EspSensorData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EspSensorData  $EspSensorData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EspSensorData $EspSensorData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EspSensorData  $EspSensorData
     * @return \Illuminate\Http\Response
     */
    public function destroy(EspSensorData $EspSensorData)
    {
        //
    }

    public function getLatest($room)
    {
        return EspSensorData::where("room_id",$room)->latest()->first();
    }


}

