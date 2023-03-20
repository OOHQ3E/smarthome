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

Route::get('/', [RoomController::class, 'index'])->name('index');
Route::get('/settings', [EspController::class, 'index'])->name('settings');
Route::get('/chart/{room}', [EspSensorController::class, 'index']);
Route::get('/esp/getLatest/{room}',[EspSensorController::class,'getLatest']);
Route::get('/getStatus/{esp}',[EspController::class,'getStatus']);
Route::get('/esp/toggle/{esp}/{status}',[EspController::class,'Toggle']);
Route::get("/create/device/{room}", [EspController::class,'createDevice']);
Route::post("/create/device/{room}", [EspController::class,'storeDevice']);
Route::delete('/device/delete/{device}', [EspController::class,'deleteDevice']);
