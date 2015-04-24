<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperacionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('operacion', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('nombre_operacion',100);
            $table->string('gerencia',100);
            $table->integer('supervisor_id')->unsigned()->nullable();
            $table->foreign('supervisor_id')->references('id')->on('trabajador');
            $table->integer('asesor_prev_riesgos_id')->unsigned()->nullable();
            $table->foreign('asesor_prev_riesgos_id')->references('id')->on('trabajador');
            $table->boolean('exist_cphs');
            $table->boolean('exist_subcontrato');
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
		Schema::drop('operacion');
	}

}
