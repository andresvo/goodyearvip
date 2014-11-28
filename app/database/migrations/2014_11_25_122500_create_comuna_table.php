<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComunaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comuna', function($table)
		{
		    $table->increments('id');
		    $table->string('nombre');
		    $table->integer('id_ciudad')->unsigned();
			$table->foreign('id_ciudad')->references('id')->on('ciudad');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comuna');
	}

}
