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
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->boolean('isOpen')->default(1);
            $table->boolean('conProrroga')->default(0);
            $table->decimal('total',9,2)->default(0);
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
