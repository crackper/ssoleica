<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajadorContratoExamMedicosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trabajador_contrato_exam_medico', function(Blueprint $table)
		{
            //$table->primary(array('trabajador_id','contrato_id','exam_medico_id'));
            $table->integer('trabajador_id')->unsigned();
            $table->foreign('trabajador_id')->references('id')->on('trabajador');
            $table->integer('contrato_id')->unsigned();
            $table->foreign('contrato_id')->references('id')->on('contrato');
            $table->integer('exam_medico_id')->unsigned();
            $table->foreign('exam_medico_id')->references('id')->on('enum_tables');
            $table->boolean('caduca')->default(true);
            $table->date('fecha_vencimiento');
            $table->longText('observaciones')->nullable();
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
		Schema::drop('trabajador_contrato_exam_medico');
	}

}
