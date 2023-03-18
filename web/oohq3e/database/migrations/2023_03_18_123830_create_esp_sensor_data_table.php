<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspSensorDataTable extends Migration {

	public function up()
	{
		Schema::create('esp_sensor_data', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('room_id')->unsigned();
			$table->float('humidity');
			$table->float('temperature');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('esp_sensor_data');
	}
}
