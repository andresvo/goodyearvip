<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usuario', function($table)
		{
		    $table->increments('id');
		    $table->string('email');
		    $table->string('pass');
		    $table->timestamps();
		    $table->integer('id_distribuidor')->unsigned();
			$table->foreign('id_distribuidor')->references('id')->on('distribuidor');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('usuario');
	}

}
