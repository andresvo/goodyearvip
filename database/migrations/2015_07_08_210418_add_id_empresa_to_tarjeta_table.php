<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdEmpresaToTarjetaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tarjeta', function(Blueprint $table)
		{
			$table->integer('id_empresa')->unsigned()->nullable();
			$table->foreign('id_empresa')->references('id')->on('empresa');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tarjeta', function(Blueprint $table)
		{
			//
		});
	}

}
