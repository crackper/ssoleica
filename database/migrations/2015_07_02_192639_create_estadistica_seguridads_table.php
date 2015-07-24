<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadisticaSeguridadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('estadistica_seguridad', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('month_id')->unsigned();
            $table->foreign('month_id')->references('id')->on('month');
            $table->integer('contrato_id')->unsigned();
            $table->foreign('contrato_id')->references('id')->on('contrato');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->boolean('isOpen')->default(1);
            $table->boolean('conProrroga')->default(0);
            $table->decimal('dotacion',9,2)->default(0);
            $table->decimal('dias_perdidos',9,2)->default(0);
            $table->integer('inc_stp')->default(0);
            $table->integer('inc_ctp')->default(0);
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
		Schema::drop('estadistica_seguridad');
	}

}
