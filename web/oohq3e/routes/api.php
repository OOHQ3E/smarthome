<?php

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Storage::append("arduino-log.txt",
        "Room: ".$request->get("room","n/a") ." " .
        "Time: " . now()->format("Y-m-d H:i:s") . ', ' .
        "Temperature: " . $request->get("temp", "n/a") . '°C, ' .
        "Humidity: " . $request->get("hum", "n/a") . '%'
    );

 DB::insert('insert into Temperature (room, time, temperature, humidity) values (?,?,?,?)',
        [$request->get("room","n/a"),
        Carbon::now(),
        $request->get("temp", "n/a"),
        $request->get("hum", "n/a")]);
});
