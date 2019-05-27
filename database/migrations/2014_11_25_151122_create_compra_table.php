<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompraTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('compra', function($table)
		{
		    $table->increments('id');
		    $table->integer('id_usuario')->unsigned();
			$table->foreign('id_usuario')->references('id')->on('usuario');
		    $table->integer('id_medida')->unsigned();
			$table->foreign('id_medida')->references('id')->on('medida');
		    $table->integer('id_tarjeta')->unsigned();
			$table->foreign('id_tarjeta')->references('id')->on('tarjeta');
		    $table->integer('cantidad');
		    $table->integer('boleta');
		    $table->integer('factura');
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
		Schema::drop('compra');
	}

}
