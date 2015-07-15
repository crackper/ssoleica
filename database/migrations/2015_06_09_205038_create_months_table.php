<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('month', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string("nombre",50);
            $table->integer("year");
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->integer('plazo')->default(7)->unsigned();
            $table->jsonb('contratos')->nullable();
            $table->json('attributes')->nullable();
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
		Schema::drop('month');
	}

}
