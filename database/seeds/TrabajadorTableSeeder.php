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
                'type'          =>  'Profesion',
                'name'          =>  $faker->name,
                'symbol'        =>  $faker->countryCode,
                'created_at'    => new DateTime,
                'updated_at'    => new DateTime
            ));

            $cargo_id = DB::table('enum_tables')->insertGetId(array(
                'type'          =>  'Cargo',
                'name'          =>  $faker->name,
                'symbol'        =>  $faker->countryCode,
                'created_at'    => new DateTime,
                'updated_at'    => new DateTime
            ));

            $estado = array('Soltero','Casado', 'Viudo','Divorciado','Conviviente');
            $grupo = array('A+','A-','B+','B-','AB+','AB-','O+','O-');
            $parentesco = array('Padre','Madre','Esposo(a)','Hijo(a)','Hermano(a)','Otro');

            DB::table('trabajador')->insert(array(
                'dni'               =>  $faker->randomNumber($nbDigits = 8),
                'nombre'            =>  $faker->name,
                'apellidos'         =>  $faker->lastName,
                'fecha_nacimiento'  =>  $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now'),
                'estado_civil'      =>  $estado[rand(0,4)],
                'direccion'         =>  $faker->address,
                'nro_telefono'      =>  $faker->phoneNumber,
                'fecha_ingreso'     =>  $faker->dateTimeBetween($startDate = '-7 years', $endDate = 'now'),
                'profesion_id'      =>  $profesion_id,
                'cargo_id'          =>  $cargo_id,
                'foto'              =>  $faker->imageUrl($width = 640, $height = 480, 'people'),
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