<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistribuidorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('distribuidor', function($table)
		{
		    $table->increments('id');
		    $table->string('nombre');
		    $table->string('direccion');
		    $table->string('telefono');
		    $table->string('web');
		    $table->timestamps();
		    $table->integer('id_comuna')->unsigned();
			$table->foreign('id_comuna')->references('id')->on('comuna');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('distribuidor');
	}

}
