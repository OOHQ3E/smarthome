<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspTable extends Migration {

	public function up()
	{
		Schema::create('esp', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('room_id')->unsigned();
			$table->string('type');
			$table->tinyInteger('ip_End')->unsigned();
			$table->string('name');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('esp');
	}
}
