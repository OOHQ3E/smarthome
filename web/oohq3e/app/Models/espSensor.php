<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class espSensor extends Model
{
    use HasFactory;
    //protected $table = 'espSensors';
    protected $primaryKey = 'id';
    protected $fillable = ['room','temperature','humidity'];
    protected $timestamp = true;
}