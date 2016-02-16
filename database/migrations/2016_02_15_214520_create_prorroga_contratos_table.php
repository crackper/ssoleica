<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades;

class CreateProrrogaContratosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prorroga_contrato', function(Blueprint $table)
		{
			$table->increments('id');

            $table->integer('solicita_id')->unsigned();
            $table->foreign('solicita_id')->references('id')->on('trabajador');
            $table->integer('aprueba_id')->nullable()->unsigned();
            $table->foreign('aprueba_id')->references('id')->on('trabajador');
            //$table->timestamp('fecha_solicitud')->default(DB::raw('CURRENT_TIMESTAMP'));
            //ALTER TABLE prorroga_contrato DROP COLUMN fecha_solicitud
            $table->dateTime('fecha_aprobacion')->nullable();

            $table->integer('contrato_id')->unsigned();
            $table->foreign('contrato_id')->references('id')->on('contrato');
            $table->integer('month_id')->unsigned();
            $table->foreign('month_id')->references('id')->on('month');
            $table->dateTime('fecha_cierre');
            $table->boolean('aprobado')->default(0);
            $table->text('comentario')->nullable();

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
		Schema::drop('prorroga_contrato');
	}

}
