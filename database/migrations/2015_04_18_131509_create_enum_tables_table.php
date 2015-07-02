<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnumTablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enum_tables', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('type',50);
            $table->string('name');
            $table->string('symbol',50)->nullable();
            $table->integer('attributes')->nullable();
            $table->json('data')->nullable();
            $table->integer('ordinal')->nullable();
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
		Schema::drop('enum_tables');
	}

}
