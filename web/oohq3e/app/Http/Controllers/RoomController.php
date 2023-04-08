<?php

namespace App\Http\Controllers;

use App\Models\Esp;
use App\Models\EspSensorData;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $rooms = Room::all();
        $esps = Esp::all();

        return view('index',[
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
        return view('room.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $request->validate([
                    'name' => 'required|max:50|unique:room']
            );
            $room = new Room;
            $room ->name = $request->get("name");
            $room->save();
            return redirect('/settings')->with("message","Successfully added a new room: ".$room->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        return view('room.modify',['room'=>$room]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $validateName = "required|max:50|unique:room";

        if ($room-> name == $request->get("name")){
            $validateName = "required|max:50";
        }
        $request->validate([
                'name' => $validateName
            ]
        );
        $Room = $room;
        $Room -> name = $request->get("name");
        $Room -> updated_at = Carbon::now();

        $Room->save();
        return redirect('/settings')->with("message","Successfully updated room: ". $Room ->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room){
        $oldData = EspSensorData::where("room_id",$room->id)->get();
        if ($oldData !== null){
            DB::delete("DELETE FROM esp_sensor_data WHERE room_id = ".$room->id.";");
        }
        $room->delete();
        return redirect('/settings')->with("message","Successfully deleted room: ".$room->name);
    }
}
