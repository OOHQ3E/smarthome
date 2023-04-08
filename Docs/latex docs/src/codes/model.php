<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Esp extends Model
{
    // $table azt adja meg hogy melyik adatbazis tablanak felel meg
    protected $table = 'esp';
    // $fillable az azt adja meg, hogy melyek azok a mezok amiket modosithatjuk
    protected $fillable = array('type', 'ip_End', 'name');
    // $timestamps pedig egy igaz-hamis valtozo, ami azt hatarozza meg, hogy generaljon-e 'created_at' es 'updated_at' mezoket
    public $timestamps = true;
}
