<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajadorOperacionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trabajador_operacion', function(Blueprint $table)
		{
            //$table->primary('trabajador_id','operacion_id');
			$table->integer('trabajador_id')->unsigned();
            $table->foreign('trabajador_id')->references('id')->on('trabajador');
            $table->integer('operacion_id')->unsigned();
            $table->foreign('operacion_id')->references('id')->on('operacion');
            $table->date('fecha_inicio')->nullable();
            $table->string('nro_fotocheck',50);
            $table->date('fecha_vencimiento');
            $table->longText('observaciones')->nullable();
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
		Schema::drop('trabajador_operacion');
	}

}
