<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftContratoTrabajadorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shift_contrato_trabajador', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('trabajador_contrato_id')->unsigned();
            $table->integer('trabajador_id')->unsigned();
            $table->integer('contrato_id')->unsigned();
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            //auditoria
            $table->timestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shift_contrato_trabajador');
	}

}
