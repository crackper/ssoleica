<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidenteFotosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('incidente_foto', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('incidente_id')->unsigned();
            $table->foreign('incidente_id')->references('id')->on('incidente');
            $table->text('archivo');
            $table->text('directorio');
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
		Schema::drop('incidente_fotos');
	}

}
