<?php

use App\Http\Controllers\EspController;
use App\Http\Controllers\RfidTagController;
use App\Http\Controllers\RfidUseDataController;
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
Route::get('/settings', [EspController::class, 'index'])->name('Settings');
Route::get('/chart/{room}', [EspSensorController::class, 'index'])->name('Sensor Data Chart');
Route::get('/esp/getLatest/{room}',[EspSensorController::class,'getLatest'])->name('Get Latest Sensor Data');
Route::get('/cam/{ip_End}',[EspController::class,'show'])->name('Show Camera Feed');

Route::get('/getStatus/{esp}',[EspController::class,'getStatus'])->name('Request Status of Toggle (esp)');
Route::get('/getTag/{esp}',[EspController::class,'getTag'])->name('Request Tag uid From RFID Reader');

Route::get('/esp/toggle/{esp}/{status}',[EspController::class,'Toggle'])->name('Get Status of Toggle (esp)');
Route::get("/create/device/{room}", [EspController::class,'create'])->name('Create New Device Form');
Route::post("/create/device/{room}", [EspController::class,'store'])->name('Store New Device (esp)');
Route::get("/modify/device/{room}/{device}",[EspController::class,'edit'])->name('Modify Device (esp) Form');
Route::post("/modify/device/{room}/{device}",[EspController::class,'update'])->name('Update Device (esp)');
Route::delete('/device/delete/{device}', [EspController::class,'destroy'])->name('Delete Device (esp)');

Route::get('/', [RoomController::class, 'index'])->name('Main Page');

Route::get("/create/room", [RoomController::class,'create'])->name('Create Room Form');
Route::post("/create/room", [RoomController::class,'store'])->name('Store New Room');
Route::get("/modify/room/{room}",[RoomController::class,'edit'])->name('Modify Room Form');
Route::post("/modify/room/{room}",[RoomController::class,'update'])->name('Update Room');
Route::delete("/delete/{room}", [RoomController::class,'destroy'])->name('Delete Room');

Route::get('/settings/RFID', [RfidTagController::class, 'index'])->name('RFID settings');
Route::get('/create/RFID/{reader}',[RfidTagController::class,'create'])->name("Create New RFID Tag Form");
Route::post('/create/RFID/{reader}',[RfidTagController::class,'store'])->name('Store New RFID Tag');
Route::get("/modify/RFID/{reader}/{tag}",[RfidTagController::class,'edit'])->name('Modify RFID tag Form');
Route::post("/modify/RFID/{reader}/{tag}",[RfidTagController::class,'update'])->name('Update RFID tag Form');
Route::delete("/delete/tag/{tag}", [RfidTagController::class,'destroy'])->name('Delete RFID tag');
Route::get("/RFID/history/",[RfidUseDataController::class,'index'])->name("RFID Use data logs page");
