<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 1/07/15
 * Time: 3:34 PM
 */

namespace SSOLeica\Core\Repository;


use Illuminate\Support\Facades\DB;
use SSOLeica\Core\Data\Repository;

class MonthRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\Month';
    }

    function getMesesDisponibles($pais, $contrato_id)
    {
        $query = "select * from month m ";
        $query .= "where m.pais_id = :pais_id ";
        $query .= "and now() between m.fecha_inicio and m.fecha_fin + ((m.plazo)::text || ' day')::interval ";
        $query .= "and id not in (select month_id from horas_hombre where contrato_id = :contrato_id)";

        $data = DB::select(DB::Raw($query),array('pais_id' => $pais,'contrato_id'=> $contrato_id));

        return $data;
    }
}