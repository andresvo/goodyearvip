<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedidaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('medida', function($table)
		{
		    $table->increments('id');
		    $table->string('nombre');
		    $table->integer('id_producto')->unsigned();
			$table->foreign('id_producto')->references('id')->on('producto');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('medida');
	}

}
