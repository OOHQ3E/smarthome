<?php

namespace App\Http\Controllers;
use App\Models\Esp;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Psy\Readline\Hoa\EventSource;

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
    public function create($room){
        $rooms = Room::all();
        $esps = Esp::all();
        $Room = Room::find($room);
        if ($Room !== null){
            $types = ["Sensor","Toggle","Camera"];
            return view("device.create",[
                'types' => $types,
                'room' => $Room
            ]);
        }
        else return view('settings',[
            'rooms' => $rooms,
            'esps' => $esps
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Room $room){
        $TempType = $request->get("type");
        $type = null;
        switch ($TempType){
            case 0:
                $type = "Sensor";
                break;
            case 1:
                $type = "Toggle";
                break;
            case 2:
                $type = "Camera";
                break;
        }
        $existing = null;
        if ($type == "Sensor"){
            $existing = DB::table("esp")
                ->where("room_id","=", $request->get("roomId"))
                ->where("type","=","Sensor")
                ->first();
        }
        if ($existing!==null){
            return back()
                ->with('error','Rooms can only have 1 Sensor!');
        }
        else{
            $request->validate([
                    'type' => 'required|max:50',
                    'name'=> 'required|max:50',
                    'ip_End' => "required|integer|between:2,149|unique:esp",
                    'roomId'=> 'required|integer'
                ]
            );
            $esp = new Esp;
            $esp ->type = $type;
            $esp ->name = $request->get("name");
            $esp ->ip_End = $request->get("ip_End");
            $esp ->room_id = $request->get("roomId");

            $esp->save();
            return redirect('/settings')
                ->with("message","Successfully added ". $esp -> name." to ".$room -> name);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Esp  $esp
     * @return \Illuminate\Http\Response
     */
    public function show($ip_End)
    {
        $device = Esp::where('ip_End',"=",$ip_End)->first();

        if ($device !== null){
            return view('room.videostream',[
                'device' => $device
            ]);
        }
        return redirect('/');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Esp  $esp
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room, Esp $device){
        $types = ["Sensor","Toggle","Camera"];
        $rooms = Room::all();
        return view('device.modify',[
            'types' => $types,
            'room'=>$room,
            'device'=>$device,
            'rooms'=>$rooms
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Esp  $esp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room, Esp $device){
        $TempType = $request->get("type");
        $type = null;
        switch ($TempType){
            case 0:
                $type = "Sensor";
                break;
            case 1:
                $type = "Toggle";
                break;
            case 2:
                $type = "Camera";
                break;
        }
        $existing = null;
        if ($type == "Sensor"){
            $existing = DB::table("esp")->where("room_id","=", $request->get("room"))->where("type","=","Sensor")->first();
        }
        if ($existing !== null && $existing->id !== $device->id){
            return back()->with('error','Rooms can only have 1 Sensor!');
        }
        else{
            $validateIP = "required|integer|between:2,149|unique:esp";

            if ($device-> ip_End == $request->get("ip_End")){
                $validateIP = "required|integer|between:2,149";

            }
            $request->validate([
                    'type' => 'required|max:50',
                    'deviceName'=> 'required|max:50',
                    'ip_End' => $validateIP,
                    'roomId'=> 'required|integer'
                ]
            );
            $esp = $device;
            $esp ->type = $type;
            $esp ->name = $request->get("deviceName");
            $esp ->ip_End = $request->get("ip_End");
            $esp ->room_id = $request->get("room");

            $esp->save();

            if ($room->id !== $request->get('room')){
                DB::delete("DELETE FROM esp_sensor_data WHERE room_id = ".$room->id.";");
            }
            return redirect('/settings')->with("message","Successfully updated ". $esp ->name);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Esp  $esp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Esp $device){
        $room = DB::table('room')->select("name")->where('id',"=",$device->room_id)->first();
        $device->delete();
        return redirect()->back()->with("message","Successfully deleted ".$device->name." from ".$room->name);
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
