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
    public function createDevice($room){
        $rooms = Room::all();
        $esps = Esp::all();
        $Room = Room::find($room);
        if ($Room !== null){
            $types = ["Sensor","Toggle"];
            return view("createDevice",[
                'types' => $types,
                'room' => $Room
            ]);
        }
        else return view('settings',[
            'rooms' => $rooms,
            'esps' => $esps
        ]);
    }
    public function storeDevice(Request $request, Room $room){
        $TempType = $request->get("type");
        $type = null;
        switch ($TempType){
            case 0:
                $type = "Sensor";
                break;
            case 1:
                $type = "Toggle";
                break;
        }
        $existing = null;
        if ($type == "Sensor"){
            $existing = DB::table("esp")->where("room_id","=", $request->get("roomId"))->where("type","=","Sensor")->first();
        }
        if ($existing!==null){
            return back()->with('error','Rooms can only have 1 Sensor!');
        }
        else{
            $request->validate([
                    'type' => 'required|max:50',
                    'deviceName'=> 'required|max:50',
                    'ip_End' => "required|integer|between:2,149|unique:esp",
                    'roomId'=> 'required|integer'
                ]
            );
            $esp = new Esp;
            $esp ->type = $type;
            $esp ->name = $request->get("deviceName");
            $esp ->ip_End = $request->get("ip_End");
            $esp ->room_id = $request->get("roomId");

            $esp->save();
            return redirect('/settings')->with("message","Successfully added ". $esp ->name." to ".$room->name);
        }
    }
    public function deleteDevice(Esp $device){
        $room = DB::table('room')->select("name")->where('id',"=",$device->room_id)->first();
        $device->delete();
        return redirect('/settings')->with("message","Successfully deleted ".$device->name." from ".$room->name);
    }
    public function modifyDevice(Room $room,Esp $device){
        $types = ["Sensor","Toggle"];
        return view('modifyDevice',[
            'types' => $types,
            'room'=>$room,
            'device'=>$device]);
    }
    public function updateDevice(Request $request, Room $room, Esp $device){
        $TempType = $request->get("type");
        $type = null;
        switch ($TempType){
            case 0:
                $type = "Sensor";
                break;
            case 1:
                $type = "Toggle";
                break;
        }
        $existing = null;
        if ($type == "Sensor"){
            $existing = DB::table("esp")->where("room_id","=", $request->get("roomId"))->where("type","=","Sensor")->first();
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
            $esp ->room_id = $request->get("roomId");

            $esp->save();
            return redirect('/settings')->with("message","Successfully updated ". $esp ->name." in ".$room->name);
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
