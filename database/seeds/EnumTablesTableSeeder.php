<?php namespace Database\Seeds;


/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 18/04/15
 * Time: 8:20 AM
 */

use Illuminate\Support\Facades\DB;
use DateTime;

class EnumTablesTableSeeder extends \Illuminate\Database\Seeder {
    public function run(){

        DB::table('enum_tables')->delete();
        
        $enums = array(
            ['id'=> 1,'type'=>'ExamenMedico','name'=>'Ex. Med. Ocupacional Anual (EMOA)','symbol'=>'EMOA','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 2,'type'=>'ExamenMedico','name'=>'Ex. Med. Ocupacional Retiro (EMOR)','symbol'=>'EMOR','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 3,'type'=>'ExamenMedico','name'=>'Ex. Med. Pre. Ocupacional (EMPO)','symbol'=>'EMPO','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 4,'type'=>'ExamenMedico','name'=>'Ex. Med. Altura Física (EMAF)','symbol'=>'EMAF','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 5,'type'=>'ExamenMedico','name'=>'Ex. Med. Altura Geográfica (EMAG)','symbol'=>'EMAG','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 6,'type'=>'ExamenMedico','name'=>'Ex. Med. Dermatológico (FOTOTIPO)','symbol' => 'FOTOTIPO','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 7,'type'=>'ExamenMedico','name'=>'Ex. Med. Psicológico','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 10,'type'=>'Cargo','name'=>'Técnico de Operaciones','symbol'=>'TOP','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 11,'type'=>'Cargo','name'=>'Ingeniero de Operaciones','symbol'=>'IOP','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 12,'type'=>'Cargo','name'=>'Asesor Prevención de Riesgos','symbol'=>'APR','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 13,'type'=>'Cargo','name'=>'Jefe de Operaciones','symbol'=>'JOP','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 14,'type'=>'Cargo','name'=>'Gerente de Operaciones','symbol'=>'GOP','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 15,'type'=>'Cargo','name'=>'Supervisor de Operaciones','symbol'=>'SOP','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 16,'type'=>'Cargo','name'=>'Gerente de Ventas','symbol'=>'GV','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 17,'type'=>'LicConducirCategory','name'=>'AI','symbol'=>'AI','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 18,'type'=>'LicConducirCategory','name'=>'AII-a','symbol'=>'AII-a','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 19,'type'=>'LicConducirCategory','name'=>'AII-b','symbol'=>'AII-b','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 20,'type'=>'LicConducirCategory','name'=>'AIII-a','symbol'=>'AIII-a','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 21,'type'=>'LicConducirCategory','name'=>'AIII-b','symbol'=>'AIII-b','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 22,'type'=>'LicConducirCategory','name'=>'AIII-c','symbol'=>'AIII-c','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 23,'type'=>'LicConducirCategory','name'=>'A1','symbol'=>'A1','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 24,'type'=>'LicConducirCategory','name'=>'A2','symbol'=>'A2','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 25,'type'=>'LicConducirCategory','name'=>'A3','symbol'=>'A3','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 26,'type'=>'LicConducirCategory','name'=>'A4','symbol'=>'A4','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 27,'type'=>'LicConducirCategory','name'=>'A5','symbol'=>'A5','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 28,'type'=>'LicConducirCategory','name'=>'B','symbol'=>'B','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 29,'type'=>'LicConducirCategory','name'=>'C','symbol'=>'C','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 30,'type'=>'LicConducirCategory','name'=>'D','symbol'=>'D','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 31,'type'=>'LicConducirCategory','name'=>'E','symbol'=>'E','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 32,'type'=>'LicConducirCategory','name'=>'F','symbol'=>'F','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 33,'type'=>'Documento','name'=>'Documento Nacional de Identidad(DNI)','symbol'=>'DNI','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 34,'type'=>'Documento','name'=>'Pasaporte','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 35,'type'=>'Documento','name'=>'Antecedentes Penales','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 36,'type'=>'Documento','name'=>'Antecedentes Judiciales','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 37,'type'=>'Documento','name'=>'Carnet de Extranjeria','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 38,'type'=>'Documento','name'=>'Licencia de Conducir','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 39,'type'=>'Entidad','name'=>'LEICA','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 40,'type'=>'Entidad','name'=>'Contratista','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 41,'type'=>'Entidad','name'=>'Cliente','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 42,'type'=>'Entidad','name'=>'Otro','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 43,'type'=>'Consecuencia','name'=>'1os Auxilios','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 44,'type'=>'Consecuencia','name'=>'Sin pérdida de días','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 45,'type'=>'Consecuencia','name'=>'Tarea restringida','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 46,'type'=>'Consecuencia','name'=>'Con pérdida de días','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 47,'type'=>'Consecuencia','name'=>'Muerte','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 48,'type'=>'ParteAfectada','name'=>'NINGUNA','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 49,'type'=>'ParteAfectada','name'=>'Cabeza','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 50,'type'=>'ParteAfectada','name'=>'Cuello','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 51,'type'=>'ParteAfectada','name'=>'Brazos','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 52,'type'=>'ParteAfectada','name'=>'Espalda','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 53,'type'=>'ParteAfectada','name'=>'Dedos','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 54,'type'=>'ParteAfectada','name'=>'Ojo','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 55,'type'=>'ParteAfectada','name'=>'Pie','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 56,'type'=>'ParteAfectada','name'=>'Manos','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 57,'type'=>'ParteAfectada','name'=>'Oídos','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 58,'type'=>'ParteAfectada','name'=>'Tobillos','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 59,'type'=>'ParteAfectada','name'=>'Hombro','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 60,'type'=>'ParteAfectada','name'=>'Antebrazo','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 61,'type'=>'Cargo','name'=>'Practicante','symbol'=>'PRACT','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 62,'type'=>'Incidente','name'=>'Seguridad','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 63,'type'=>'Incidente','name'=>'Salud Ocupacional','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 64,'type'=>'Incidente','name'=>'Medio Ambiente','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 65,'type'=>'Incidente','name'=>'Operacional','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 66,'type'=>'Informe','name'=>'Preliminar','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 67,'type'=>'Informe','name'=>'Definitivo','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 68,'type'=>'Cargo','name'=>'Técnico de Electronico','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 69,'type'=>'Cargo','name'=>'TOOLS AND MACHINE CONTROL DIVISION','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 70,'type'=>'Cargo','name'=>'VICE PRESIDENT SOUTHAMERICA & GENERAL MANAGER GLOBAL SALES','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 71,'type'=>'Cargo','name'=>'PREVENCIONISTA DE RIESGOS','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 72,'type'=>'Cargo','name'=>'INGENIERO SAFETY','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 73,'type'=>'Cargo','name'=>'INGENIERO DE VENTAS ','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 74,'type'=>'Cargo','name'=>'INGENIERO DE SOPORTE','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 75,'type'=>'Cargo','name'=>'INGENIERO DE PROYECTOS','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 76,'type'=>'Cargo','name'=>'GERENTE MANTEN. Y SOPORTE','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 77,'type'=>'Cargo','name'=>'GERENTE GENERAL','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 78,'type'=>'Cargo','name'=>'ESPECIALISTA TECNICO','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 79,'type'=>'Cargo','name'=>'CONTROLLER','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 80,'type'=>'Cargo','name'=>'CONTADOR GENERAL','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 81,'type'=>'Cargo','name'=>'CONTADOR','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 82,'type'=>'Cargo','name'=>'ASISTENTE OFICINA','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 83,'type'=>'Cargo','name'=>'ASISTENTE','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 84,'type'=>'Cargo','name'=>'Support Chief','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 85,'type'=>'Cargo','name'=>'Support Engineer','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 86,'type'=>'Cargo','name'=>'Product Especialist','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 87,'type'=>'Cargo','name'=>'Support Engineer','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 88,'type'=>'Cargo','name'=>'Ingeniero Prevencion de Riesgos','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 89,'type'=>'Cargo','name'=>'Tecnico de Laboratorio','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 90,'type'=>'Cargo','name'=>'Tecnico Comunicaciones y Redes','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 91,'type'=>'Cargo','name'=>'Ingeniero Residente','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 92,'type'=>'Cargo','name'=>'Ingeniero Operaciones Senior','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 93,'type'=>'Cargo','name'=>'Ingeniero de Redes','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 94,'type'=>'Cargo','name'=>'Expeditor','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 95,'type'=>'Cargo','name'=>'Administrativo','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 96,'type'=>'Profesion','name'=>'Otro','symbol'=>'','created_at' => new DateTime, 'updated_at' => new DateTime]

        );

        DB::table('enum_tables')->insert($enums);

        DB::statement('ALTER SEQUENCE enum_tables_id_seq RESTART WITH 97');

        $paises = array(
            ['id'=> 8,'type'=>'Pais','name'=>'Perú','symbol'=>'PE','data'=>json_encode(array('timezone'=>'America/Bogota')),'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 9,'type'=>'Pais','name'=>'Chile','symbol'=>'CL','data'=>json_encode(array('timezone'=>'America/Argentina/Buenos_Aires')),'created_at' => new DateTime, 'updated_at' => new DateTime]
        );

        DB::table('enum_tables')->insert($paises);

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