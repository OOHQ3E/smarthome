<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfidTagTable extends Migration {

	public function up()
	{
		Schema::create('rfid_tag', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 50);
            $table->string('uid',20);
			$table->integer('esp_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('rfid_tag');
	}
}
