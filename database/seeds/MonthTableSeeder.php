<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 10/06/15
 * Time: 8:57 AM
 */
namespace Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class MonthTableSeeder extends Seeder {

    public function run(){
        DB::table('month')->delete();

        $years = array('2015','2016','2017','2018','2019','2020');
        $months = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

        $cont = 0;

            foreach( $years as $id => $year)
            {
                foreach($months as $key => $month){

                    $d = 1;
                    $m = $key + 1;
                    $Y = $year;
                    $utc = 0;

                    $primerDia = gmdate("Y-m-d H:i:s", mktime(0, 0, 0,$m, $d-$d +1,$Y) + $utc);
                    $ultimoDia = gmdate("Y-m-d H:i:s", mktime(23, 59, 59,$m+1,$d-$d,$Y) + $utc);

                    if($cont == 7 || $cont == 8)
                    {
                        $contratos[] = array('contrato'=>1,"extra"=>5,'comentario'=>'nok','created_at' => new DateTime, 'updated_at' => new DateTime, 'created_by' =>'samuel');
                        $contratos[] = array('contrato'=>2,"extra"=>5,'comentario'=>'ok','created_at' => new DateTime, 'updated_at' => new DateTime, 'created_by' =>'samuel');

                        DB::table('month')->insert(array('nombre' => $month,'year' => $year,'fecha_inicio' => $primerDia, 'fecha_fin' => $ultimoDia,'contratos' => json_encode($contratos),'created_at' => new DateTime, 'updated_at' => new DateTime));
                    }
                    else
                    {
                        DB::table('month')->insert(array('nombre' => $month,'year' => $year,'fecha_inicio' => $primerDia, 'fecha_fin' => $ultimoDia,'created_at' => new DateTime, 'updated_at' => new DateTime));
                    }

                    $cont++;
                }
            }


    }
} 