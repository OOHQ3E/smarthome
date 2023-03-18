<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Esp extends Model
{

    protected $table = 'esp';
    protected $fillable = array('type', 'ip_End', 'name');
    public $timestamps = true;

}
