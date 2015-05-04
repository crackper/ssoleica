<?php namespace Database\Seeds;


/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 18/04/15
 * Time: 8:20 AM
 */

use Illuminate\Support\Facades\DB;
use DateTime;
use Faker\Factory as Faker;

class EnumTablesTableSeeder extends \Illuminate\Database\Seeder {
    public function run(){

        DB::table('enum_tables')->delete();
        
        $enums = array(
            ['id'=> 1,'type'=>'ExamenMedico','name'=>'Ex. Med. Ocupacional Anual (EMOA)','symbol'=>'EMOA','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 2,'type'=>'ExamenMedico','name'=>'Ex. Med. Ocupacional Retiro (EMOR)','symbol'=>'EMOR','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 3,'type'=>'ExamenMedico','name'=>'Ex. Med. Pre. Ocupacional (EMPO)','symbol'=>'EMPO','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 4,'type'=>'ExamenMedico','name'=>'Ex. Med. Altura Física (EMAF)','symbol'=>'EMAF','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 5,'type'=>'ExamenMedico','name'=>'Ex. Med. Altura Geográfica (EMAG)','symbol'=>'EMAG','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 6,'type'=>'ExamenMedico','name'=>'Ex. Med. Dermatológico','symbol' => '','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 7,'type'=>'ExamenMedico','name'=>'Ex. Med. Psicológico','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 8,'type'=>'Pais','name'=>'Perú','symbol'=>'PE','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 9,'type'=>'Pais','name'=>'Chile','symbol'=>'CL','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 10,'type'=>'Cargo','name'=>'Técnico de Operaciones','symbol'=>'TOP','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 11,'type'=>'Cargo','name'=>'Ingeniero de Operacioens','symbol'=>'IOP','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 12,'type'=>'Cargo','name'=>'Asesor Prevención de Riesgos','symbol'=>'APR','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 13,'type'=>'Cargo','name'=>'Jefe de Operaciones','symbol'=>'JOP','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 14,'type'=>'Cargo','name'=>'Gerente de Operaciones','symbol'=>'GOP','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 15,'type'=>'Cargo','name'=>'Supervisor de Operaciones','symbol'=>'SOP','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 16,'type'=>'Cargo','name'=>'Gerente de Ventas','symbol'=>'GV','created_at' => new DateTime, 'updated_at' => new DateTime]
        );
        DB::table('enum_tables')->insert($enums);

        /*$faker = Faker::create();

        for($i = 0; $i<30; $i++)
        {
            DB::table('enum_tables')->insert(array(
                'type'          =>  $faker->ean13,
                'name'          =>  $faker->name,
                'symbol'        =>  $faker->countryCode,
                'created_at'    => new DateTime,
                'updated_at'    => new DateTime
            ));
        }*/
    }
} 