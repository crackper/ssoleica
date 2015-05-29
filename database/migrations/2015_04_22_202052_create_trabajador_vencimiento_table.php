<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajadorVencimientoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trabajador_vencimiento', function(Blueprint $table)
		{
            //$table->primary(array('trabajador_id','operacion_id','exam_medico_id'));
            $table->increments('id');
            $table->integer('trabajador_id')->unsigned();
            $table->foreign('trabajador_id')->references('id')->on('trabajador');
            $table->integer('operacion_id')->nullable()->unsigned();
            $table->foreign('operacion_id')->references('id')->on('operacion');
            $table->integer('vencimiento_id')->unsigned();
            $table->foreign('vencimiento_id')->references('id')->on('enum_tables');
            $table->string('type',50);
            $table->boolean('caduca')->default(true);
            $table->date('fecha_vencimiento');
            $table->longText('observaciones')->nullable();
            //auditoria
            $table->timestamps();
            $table->softDeletes();
		});

       //DB::unprepared('ALTER TABLE trabajador_operacion_exam_medico DROP PRIMARY KEY, ADD PRIMARY KEY(trabajador_id,operacion_id,exam_medico_id)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('trabajador_vencimiento');
	}

}
