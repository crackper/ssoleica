<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 17/02/16
 * Time: 7:30 AM
 */
namespace SSOLeica\Core\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

trait Prorrogas {

    function getCantProrrogasPendientes($pais_id){

        $query_pr= "select count(*) as cant from prorroga_contrato pc ";
        $query_pr .= "inner join contrato c on pc.contrato_id = c.id ";
        $query_pr .= "inner join operacion o on c.operacion_id = o.id ";
        $query_pr .= 'where pc."aprobado" = false and o.pais_id = :pais_id';

        $cant_pr = DB::select(DB::Raw($query_pr),array('pais_id' => $pais_id));

        Session::put('cant_pr', $cant_pr[0]->cant);
    }
}



?>