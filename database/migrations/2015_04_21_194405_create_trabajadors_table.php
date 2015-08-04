<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajadorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trabajador', function(Blueprint $table)
		{
            //datos generales
            $table->increments('id');
            $table->string('dni',20);
            $table->string('nombre',100);
            $table->string('app_paterno',200);
            $table->string('app_materno',200);
            $table->enum('sexo',['M','F']);
            $table->date('fecha_nacimiento');
            $table->enum('estado_civil', ['Soltero','Casado', 'Viudo','Divorciado','Conviviente'])->default('Soltero');
            $table->string('direccion')->nullable();
            $table->string('email')->nullable();
            $table->string('nro_telefono',50)->nullable();
            $table->date('fecha_ingreso');
            $table->integer('profesion_id')->unsigned();
            $table->foreign('profesion_id')->references('id')->on('enum_tables');
            $table->integer('cargo_id')->unsigned();
            $table->foreign('cargo_id')->references('id')->on('enum_tables');
            $table->date('fecha_ini_cargo');
            $table->integer('pais_id')->unsigned();
            $table->foreign('pais_id')->references('id')->on('enum_tables');

            //informacion adicional
            $table->longText('foto')->nullable();
            $table->enum('grupo_saguineo',['','A+','A-','B+','B-','AB+','AB-','O+','O-'])->nullable();
            $table->string('lic_conducir')->nullable();
            $table->integer('lic_categoria_id')->unsigned()->nullable();
            //$table->integer('lic_clase_id')->unsigned()->nullable();
            //$table->date('lic_fecha_vencimiento')->nullable();
            $table->string('em_nombres')->nullable();
            $table->string('em_telef_fijo')->nullable();
            $table->string('em_telef_celular')->nullable();
            $table->enum('em_parentesco',['','Padre','Madre','Esposo(a)','Hijo(a)','Hermano(a)','Otro'])->nullable();
            $table->string('em_direccion')->nullable();
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
		Schema::drop('trabajador');
	}

}
