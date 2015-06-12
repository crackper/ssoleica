<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorasHombresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('horas_hombre', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('month_id')->unsigned();
            $table->foreign('month_id')->references('id')->on('month');
            $table->integer('contrato_id')->unsigned();
            $table->foreign('contrato_id')->references('id')->on('contrato');
            $table->integer('trabajador_id')->unsigned();
            $table->foreign('trabajador_id')->references('id')->on('trabajador');
            $table->integer('horas_trabajadas')->default(0);
            $table->json('extra')->nullable();
            //auditoria
            $table->string('updated_by',100)->nullable();
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
		Schema::drop('horas_hombre');
	}

}
