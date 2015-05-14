<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadosContratosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('estados_contrato', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('contrato_id')->unsigned();
            $table->foreign('contrato_id')->references('id')->on('contrato');
            $table->integer('supervisor_id')->unsigned();
            $table->integer('asesor_prev_riesgos_id')->unsigned();
            $table->boolean('exist_cphs');
            $table->boolean('exist_subcontrato');
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
		Schema::drop('estados_contrato');
	}

}
