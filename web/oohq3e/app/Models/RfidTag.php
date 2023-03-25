<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RfidTag extends Model
{

    protected $table = 'rfid_tag';
    public $timestamps = true;
    protected $fillable = array('name', 'esp_id', 'uid');

}
