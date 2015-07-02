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

        $years = array('39'=>'2015','40'=>'2016','41'=>'2017','42'=>'2018','43'=>'2019','44'=>'2020');
        $months = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $paises = array(8,9);

        $cont = 0;
        foreach($paises as $p => $pais )
        {
            foreach( $years as $id => $year)
            {
                foreach($months as $key => $month){

                    $d = 1;
                    $m = $key + 1;
                    $Y = $year;
                    $utc = 0;

                    /*if($pais == 8)
                        $utc = 3600*5;
                    else
                        $utc = 3600*3;*/

                    $primerDia = gmdate("Y-m-d H:i:s", mktime(0, 0, 0,$m, $d-$d +1,$Y) + $utc);
                    $ultimoDia = gmdate("Y-m-d H:i:s", mktime(23, 59, 59,$m+1,$d-$d,$Y) + $utc);

                    if($cont == 4 || $cont == 5)
                    {
                        $contratos[] = array('contrato'=>1,"extra"=>5,'comentario'=>'nok','created_at' => new DateTime, 'updated_at' => new DateTime, 'created_by' =>'samuel');
                        $contratos[] = array('contrato'=>2,"extra"=>5,'comentario'=>'ok','created_at' => new DateTime, 'updated_at' => new DateTime, 'created_by' =>'samuel');

                        DB::table('month')->insert(array('nombre' => $month,'year' => $year,'year_id' => $id,'pais_id' => $pais,'fecha_inicio' => $primerDia, 'fecha_fin' => $ultimoDia,'contratos' => json_encode($contratos),'created_at' => new DateTime, 'updated_at' => new DateTime));

                        $contratos = array();
                    }
                    else
                    {
                        DB::table('month')->insert(array('nombre' => $month,'year' => $year,'year_id' => $id,'pais_id' => $pais,'fecha_inicio' => $primerDia, 'fecha_fin' => $ultimoDia,'created_at' => new DateTime, 'updated_at' => new DateTime));
                    }

                    $cont++;
                }
            }
        }

    }
} 