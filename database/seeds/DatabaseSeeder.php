<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('Database\Seeds\UserTableSeeder');
        $this->call('Database\Seeds\EnumAttributesTableSeeder');
        $this->call('Database\Seeds\EnumTablesTableSeeder');
        //$this->call('Database\Seeds\TrabajadorTableSeeder');
        $this->call('Database\Seeds\MonthTableSeeder');
	}

}
