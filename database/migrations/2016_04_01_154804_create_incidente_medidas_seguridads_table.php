<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidenteMedidasSeguridadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('incidente_medidas_seguridad', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('incidente_id')->unsigned();
            $table->foreign('incidente_id')->references('id')->on('incidente');
            $table->string('type',50);
            $table->text('accion');
            $table->dateTime('fecha_comprometida');
            $table->json("responsables");

            //other
            $table->json('attr')->nullable();
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
		Schema::drop('incidente_medidas_seguridads');
	}

}
