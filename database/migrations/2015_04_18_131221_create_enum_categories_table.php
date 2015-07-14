<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnumCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enum_categories', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('enum_value_id');
            $table->integer('category_id');
            $table->string('updated_by',100)->nullable();
            $table->json('attributes')->nullable();
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
		Schema::drop('enum_categories');
	}

}
