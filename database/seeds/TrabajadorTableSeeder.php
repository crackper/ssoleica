<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 21/04/15
 * Time: 3:55 PM
 */

namespace Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;
use Faker\Factory as Faker;


class TrabajadorTableSeeder extends Seeder {

    public function run(){

        DB::table('trabajador')->delete();

        $faker = Faker::create();

        for($i = 0; $i<50; $i++)
        {
           $profesion_id = DB::table('enum_tables')->insertGetId(array(
                //'id'            => 45 + $i,
                'type'          =>  'Profesion',
                'name'          =>  $faker->name,
                'symbol'        =>  $faker->countryCode,
                'created_at'    => new DateTime,
                'updated_at'    => new DateTime
            ));

            /*$cargo_id = DB::table('enum_tables')->insertGetId(array(
                'type'          =>  'Cargo',
                'name'          =>  $faker->name,
                'symbol'        =>  $faker->countryCode,
                'created_at'    => new DateTime,
                'updated_at'    => new DateTime
            ));*/

            $estado = array('Soltero','Casado', 'Viudo','Divorciado','Conviviente');
            $grupo = array('A+','A-','B+','B-','AB+','AB-','O+','O-');
            $parentesco = array('Padre','Madre','Esposo(a)','Hijo(a)','Hermano(a)','Otro');
            $sexo = array('M','F');

            DB::table('trabajador')->insert(array(
                'pais_id'           =>  rand(8,9),
                'dni'               =>  $faker->randomNumber($nbDigits = 8),
                'nombre'            =>  $faker->name,
                'app_paterno'       =>  $faker->firstName,
                'app_materno'       =>  $faker->lastName,
                'sexo'              =>  $sexo[rand(0,1)],
                'fecha_nacimiento'  =>  $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now'),
                'estado_civil'      =>  $estado[rand(0,4)],
                'direccion'         =>  $faker->address,
                'email'             =>  $faker->companyEmail,
                'nro_telefono'      =>  $faker->phoneNumber,
                'fecha_ingreso'     =>  $faker->dateTimeBetween($startDate = '-7 years', $endDate = 'now'),
                'profesion_id'      =>  $profesion_id,
                'cargo_id'          =>  rand(10,16),
                'foto'              =>  'people.jpeg',
                'grupo_saguineo'    =>   $grupo[rand(0,7)],
                'em_nombres'        =>  $faker->name.' '.$faker->lastName,
                'em_telef_fijo'     =>  $faker->phoneNumber,
                'em_telef_celular'  =>  $faker->phoneNumber,
                'em_parentesco'     =>  $parentesco[rand(0,5)],
                'em_direccion'      =>  $faker->address,
                'created_at'        => new DateTime,
                'updated_at'        => new DateTime
            ));
        }

    }

} 