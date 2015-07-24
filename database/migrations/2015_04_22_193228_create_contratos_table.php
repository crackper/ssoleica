<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contrato', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('nombre_contrato',200);
            $table->string('gerencia',200);
            $table->integer('operacion_id')->unsigned();
            $table->foreign('operacion_id')->references('id')->on('operacion');
            $table->integer('supervisor_id')->unsigned();
            $table->foreign('supervisor_id')->references('id')->on('trabajador');
            $table->integer('asesor_prev_riesgos_id')->unsigned();
            $table->foreign('asesor_prev_riesgos_id')->references('id')->on('trabajador');
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();
            $table->boolean('is_activo')->default(1);
            $table->boolean('exist_cphs')->default(0);
            $table->boolean('exist_subcontrato')->default(0);
            $table->longText('observaciones')->nullable();
            $table->json('attributes')->nullable();
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
		Schema::drop('contrato');
	}

}
