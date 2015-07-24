<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleHorasHombresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('detalle_horas_hombre', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('horas_hombre_id')->unsigned();
            $table->foreign('horas_hombre_id')->references('id')->on('horas_hombre');
            $table->integer('trabajador_id')->unsigned();
            $table->foreign('trabajador_id')->references('id')->on('trabajador');
            $table->decimal('horas',9,2)->default(0);
            //$table->json('extra')->nullable();
            $table->json('attributes')->nullable();
            //auditoria
            $table->json('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });;
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detalle_horas_hombre');
	}

}
