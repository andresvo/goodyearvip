<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNumeroToTarjetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarjeta', function (Blueprint $table) {
			$table->integer('numero')->nullable()->after('codigo');
		});
		DB::table('tarjeta')->where('tipo',1)->where('codigo', 'like', 'GY%')->update(['numero' => DB::raw( 'convert(replace(substring(codigo, 3, 5), \'E\', \'\'), signed)' )]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarjeta', function (Blueprint $table) {
            //
        });
    }
}
