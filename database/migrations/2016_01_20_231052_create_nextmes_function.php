<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNextmesFunction extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        $query = 'CREATE OR REPLACE FUNCTION nextmes() RETURNS date AS ';
        $query .= '$$ ';
        $query .= "select ((date_trunc('month', now()) + interval '1 month') - interval'0 day')::date; ";
        $query .= '$$ ';
        $query .= 'LANGUAGE SQL;';

        DB::statement($query);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//

	}

}
