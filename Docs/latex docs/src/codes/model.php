<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Esp extends Model
{
    // $table azt adja meg hogy melyik adatbázis táblának felel meg
    protected $table = 'esp';
    // $fillable az azt adja meg, hogy melyek azok a mezők amiket módosíthatunk
    protected $fillable = array('type', 'ip_End', 'name');
    // $timestamps pedig egy igaz-hamis változó, ami azt határozza meg, hogy generáljon-e 'created_at' és 'updated_at' mezőket
    public $timestamps = true;
}
