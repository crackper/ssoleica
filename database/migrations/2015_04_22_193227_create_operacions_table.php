<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperacionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('operacion', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('nombre_operacion',100);
            $table->string('ubicacion',200)->nullable();
            $table->longText('descripcion')->nullable();
            $table->integer('pais_id')->unsigned();
            $table->foreign('pais_id')->references('id')->on('enum_tables');
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
		Schema::drop('operacion');
	}

}
