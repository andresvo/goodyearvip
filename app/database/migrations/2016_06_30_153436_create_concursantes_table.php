<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConcursantesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('concursantes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->string('email');
			$table->string('marca');
			$table->string('modelo');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('concursantes');
	}

}
