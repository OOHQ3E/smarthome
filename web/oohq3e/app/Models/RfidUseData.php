<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RfidUseData extends Model
{

    protected $table = 'rfid_use_data';
    protected $fillable = array('tag_id');
    public $timestamps = true;

}
