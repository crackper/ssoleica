<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargosTrabajadorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cargos_trabajador', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('trabajador_id')->unsigned();
            $table->foreign('trabajador_id')->references('id')->on('trabajador');
            $table->integer('cargo_id')->unsigned();
            $table->dateTime('inicio');
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
		Schema::drop('cargos_trabajador');
	}

}
