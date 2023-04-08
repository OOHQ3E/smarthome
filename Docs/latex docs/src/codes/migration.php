<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspTable extends Migration {
	// az up metodus akkor fut le amikor uj esp tablat general
	public function up()
	{
			//itt megadjuk azt hogy az esp tablat szeretnenk beallitani
		Schema::create('esp', function(Blueprint $table) {
			// automatikusan novekvo azonosito
			$table -> increments('id');
			// elojel nelkuli szoba azonosito
			$table -> integer('room_id')->unsigned();
			// esp tipusa ami szoveges
			$table -> string('type');
			// tinyinteger az 0-255 ertekek kozott az ip vegzodesre
			$table -> tinyInteger('ip_End')->unsigned();
			// esp neve ami szoveges
			$table -> string('name');
			// 'created_at' es 'updated_at' mezok
			$table -> timestamps();
		});
	}
	// a down metodus akkor fut le, hogy ha toroljuk az esp tablat
	public function down()
	{
		Schema::dropIfExists('esp');
	}
}