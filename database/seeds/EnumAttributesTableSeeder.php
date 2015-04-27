<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 18/04/15
 * Time: 8:18 AM
 */
namespace Database\Seeds;

use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use DateTime;

class EnumAttributesTableSeeder extends \Illuminate\Database\Seeder {
    public function run(){
        DB::table('enum_attributes')->delete();
        $enums = array(
            ['id'=> 1,'enum_class'=>'ExamenMedico','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 2,'enum_class'=>'Fotocheck','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 3,'enum_class'=>'Monitoreo','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 4,'enum_class'=>'Pais','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 5,'enum_class'=>'Cargo','created_at' => new DateTime, 'updated_at' => new DateTime]
        );
        DB::table('enum_attributes')->insert($enums);

        $faker = Faker::create();

        for($i = 0; $i<10;$i++)
        {
            DB::table('enum_attributes')->insert(array(
                'enum_class' => $faker->company,
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ));
        }

    }
} 