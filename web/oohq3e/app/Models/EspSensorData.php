<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EspSensorData extends Model
{

    protected $table = 'esp_sensor_data';
    protected $fillable = array('room_id','humidity', 'temperature');
    public $timestamps = true;

}
