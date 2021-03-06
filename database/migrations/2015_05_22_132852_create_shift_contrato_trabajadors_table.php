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
            $table->datetime('fecha_inicio');
            $table->datetime('fecha_fin')->nullable();
            //auditoria
            $table->json('updated_by')->nullable();
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
