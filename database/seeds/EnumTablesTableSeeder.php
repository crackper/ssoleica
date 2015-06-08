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
            ['id'=> 16,'type'=>'Cargo','name'=>'Gerente de Ventas','symbol'=>'GV','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 17,'type'=>'LicConducir','name'=>'AI','symbol'=>'AI','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 18,'type'=>'LicConducir','name'=>'AII-a','symbol'=>'AII-a','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 19,'type'=>'LicConducir','name'=>'AII-b','symbol'=>'AII-b','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 20,'type'=>'LicConducir','name'=>'AIII-a','symbol'=>'AIII-a','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 21,'type'=>'LicConducir','name'=>'AIII-b','symbol'=>'AIII-b','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 22,'type'=>'LicConducir','name'=>'AIII-c','symbol'=>'AIII-c','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 23,'type'=>'LicConducir','name'=>'A1','symbol'=>'A1','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 24,'type'=>'LicConducir','name'=>'A2','symbol'=>'A2','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 25,'type'=>'LicConducir','name'=>'A3','symbol'=>'A3','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 26,'type'=>'LicConducir','name'=>'A4','symbol'=>'A4','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 27,'type'=>'LicConducir','name'=>'A5','symbol'=>'A5','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 28,'type'=>'LicConducir','name'=>'B','symbol'=>'B','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 29,'type'=>'LicConducir','name'=>'C','symbol'=>'C','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 30,'type'=>'LicConducir','name'=>'D','symbol'=>'D','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 31,'type'=>'LicConducir','name'=>'E','symbol'=>'E','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 32,'type'=>'LicConducir','name'=>'F','symbol'=>'F','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 33,'type'=>'Documento','name'=>'Documento Nacional de Identidad(DNI)','symbol'=>'DNI','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 34,'type'=>'Documento','name'=>'Pasaporte','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 35,'type'=>'Documento','name'=>'Antecedentes Penales','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 36,'type'=>'Documento','name'=>'Antecedentes Judiciales','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 37,'type'=>'Documento','name'=>'Carnet de Extranjeria','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime]
        );
        DB::table('enum_tables')->insert($enums);


        DB::table('enum_categories')->delete();

        $categories = array(
            ['id'=>'1','enum_value_id' => '17','category_id' => '8','created_at' => new DateTime, 'updated_at' => new DateTime ],
            ['id'=>'2','enum_value_id' => '18','category_id' => '8','created_at' => new DateTime, 'updated_at' => new DateTime ],
            ['id'=>'3','enum_value_id' => '19','category_id' => '8','created_at' => new DateTime, 'updated_at' => new DateTime ],
            ['id'=>'4','enum_value_id' => '20','category_id' => '8','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=>'5','enum_value_id' => '21','category_id' => '8','created_at' => new DateTime, 'updated_at' => new DateTime ],
            ['id'=>'6','enum_value_id' => '22','category_id' => '8','created_at' => new DateTime, 'updated_at' => new DateTime ],
            ['id'=>'7','enum_value_id' => '23','category_id' => '9','created_at' => new DateTime, 'updated_at' => new DateTime ],
            ['id'=>'8','enum_value_id' => '24','category_id' => '9','created_at' => new DateTime, 'updated_at' => new DateTime ],
            ['id'=>'9','enum_value_id' => '25','category_id' => '9','created_at' => new DateTime, 'updated_at' => new DateTime ],
            ['id'=>'10','enum_value_id' => '26','category_id' => '9','created_at' => new DateTime, 'updated_at' => new DateTime ],
            ['id'=>'11','enum_value_id' => '27','category_id' => '9','created_at' => new DateTime, 'updated_at' => new DateTime ],
            ['id'=>'12','enum_value_id' => '28','category_id' => '9','created_at' => new DateTime, 'updated_at' => new DateTime ],
            ['id'=>'13','enum_value_id' => '29','category_id' => '9','created_at' => new DateTime, 'updated_at' => new DateTime ],
            ['id'=>'14','enum_value_id' => '30','category_id' => '9','created_at' => new DateTime, 'updated_at' => new DateTime ],
            ['id'=>'15','enum_value_id' => '31','category_id' => '9','created_at' => new DateTime, 'updated_at' => new DateTime ],
            ['id'=>'16','enum_value_id' => '32','category_id' => '9','created_at' => new DateTime, 'updated_at' => new DateTime ],
        );

        DB::table('enum_categories')->insert($categories);

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