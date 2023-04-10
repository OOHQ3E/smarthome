<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspTable extends Migration {
	// az up metódus akkor fut le amikor új esp táblát generál
	public function up()
	{
			//itt megadjuk azt hogy az esp táblát szeretnénk beállítani
		Schema::create('esp', function(Blueprint $table) {
			// automatikusan növekvő azonosító
			$table -> increments('id');
			// előjel nélküli szoba azonosító
			$table -> integer('room_id')->unsigned();
			// esp típusa ami szöveges
			$table -> string('type');
			// tinyinteger az 0-255 értékek között az ip végrődésre
			$table -> tinyInteger('ip_End')->unsigned();
			// esp neve ami szöveges
			$table -> string('name');
			// 'created_at' es 'updated_at' mezők
			$table -> timestamps();
		});
	}
	// a down metódus akkor fut le, hogy ha töröljük az esp táblát
	public function down()
	{
		Schema::dropIfExists('esp');
	}
}