<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfidUseDataTable extends Migration {

	public function up()
	{
		Schema::create('rfid_use_data', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('tag_id')->unsigned();
            $table->integer('esp_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('rfid_use_data');
	}
}
