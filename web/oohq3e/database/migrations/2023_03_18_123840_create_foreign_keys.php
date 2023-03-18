<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('esp_sensor_data', function(Blueprint $table) {
			$table->foreign('room_id')->references('id')->on('room')
						->onDelete('cascade')
						->onUpdate('restrict');
		});
		Schema::table('esp', function(Blueprint $table) {
			$table->foreign('room_id')->references('id')->on('room')
						->onDelete('cascade')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('esp_sensor_data', function(Blueprint $table) {
			$table->dropForeign('esp_sensor_data_room_id_foreign');
		});
		Schema::table('esp', function(Blueprint $table) {
			$table->dropForeign('esp_room_id_foreign');
		});
	}
}
