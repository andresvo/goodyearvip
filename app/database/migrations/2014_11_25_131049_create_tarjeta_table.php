<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarjetaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tarjeta', function($table)
		{
		    $table->increments('id');
		    $table->string('codigo')->unique();
		    $table->integer('cupo_inicial');
		    $table->integer('cupo_actual');
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
		Schema::drop('tarjeta');
	}

}
