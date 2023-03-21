<?php

use App\Http\Controllers\EspController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\EspSensorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/settings', [EspController::class, 'index'])->name('settings');
Route::get('/chart/{room}', [EspSensorController::class, 'index']);
Route::get('/esp/getLatest/{room}',[EspSensorController::class,'getLatest']);

Route::get('/getStatus/{esp}',[EspController::class,'getStatus']);
Route::get('/esp/toggle/{esp}/{status}',[EspController::class,'Toggle']);
Route::get("/create/device/{room}", [EspController::class,'create']);
Route::post("/create/device/{room}", [EspController::class,'store']);
Route::delete('/device/delete/{device}', [EspController::class,'destroy']);
Route::get("/modify/device/{room}/{device}",[EspController::class,'edit']);
Route::post("/modify/device/{room}/{device}",[EspController::class,'update']);

Route::get('/', [RoomController::class, 'index'])->name('index');
Route::get("/create/room", [RoomController::class,'create']);
Route::post("/create/room", [RoomController::class,'store']);
Route::delete("/delete/{room}", [RoomController::class,'destroy']);
Route::get("/modify/room/{room}",[RoomController::class,'edit']);
Route::post("/modify/room/{room}",[RoomController::class,'update']);

Route::get('/cam',[EspController::class,'show']);
