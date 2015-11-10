<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('incidente', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('version')->default(1);
            $table->integer('pais_id')->unsigned();
            $table->foreign('pais_id')->references('id')->on('enum_tables');
            $table->boolean('isClose')->default(0);
            //general
            $table->integer('contrato_id')->unsigned();
            $table->foreign('contrato_id')->references('id')->on('contrato');
            $table->integer('tipo_informe_id')->unsigned();
            $table->foreign('tipo_informe_id')->references('id')->on('enum_tables');
            $table->integer('tipo_incidente_id')->unsigned();
            $table->foreign('tipo_incidente_id')->references('id')->on('enum_tables');
            $table->dateTime('fecha');
            $table->string("lugar");
            $table->string("punto");
            $table->string("equipos");
            $table->string("parte");
            $table->string("sector");
            $table->integer('responsable_id')->unsigned();
            $table->foreign('responsable_id')->references('id')->on('trabajador');
            $table->json('tr_afectados');
            $table->json('tr_involucrados');
            //circunstancias
            $table->integer('jornada_id')->unsigned();
            $table->foreign('jornada_id')->references('id')->on('enum_tables');
            $table->string('naturaleza');
            $table->string('actividad');
            $table->string('equipo');
            $table->string('parte_equipo');
            $table->string('producto');
            $table->text('des_situacion');
            //perdidas
            $table->json('partes_afectas');
            $table->json('entidad');
            $table->json('consecuencia');
            $table->integer('dias_perdidos');
            $table->text('cons_posibles');
            //daños
            $table->json('entidad_sini_mat');
            $table->text('danios_mat');
            $table->text('desc_danios_mat');
            $table->json('entidad_sini_amb');
            $table->text('lugar_danios_amb');
            $table->text('desc_danios_amb');
            //fotografias
            $table->json('fotos');
            //other
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
		Schema::drop('incidente');
	}

}
