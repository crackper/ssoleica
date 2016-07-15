<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIncidCorreSiglasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        DB::statement(" ALTER TABLE incidente ADD COLUMN register_by integer NOT NULL");
        DB::statement(" ALTER TABLE incidente ADD FOREIGN KEY (register_by) REFERENCES public.trabajador (id)");
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
