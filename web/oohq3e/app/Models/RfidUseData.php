<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfidUseData extends Model
{

    protected $table = 'rfid_use_data';
    protected $fillable = array('tag_id','esp_id');
    public $timestamps = true;

}
