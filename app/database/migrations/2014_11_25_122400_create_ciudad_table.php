<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiudadTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ciudad', function($table)
		{
		    $table->increments('id');
		    $table->string('nombre');
		    $table->integer('id_region')->unsigned();
			$table->foreign('id_region')->references('id')->on('region');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ciudad');
	}

}
