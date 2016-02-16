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

    function getMesesDisponibles($timezone, $contrato_id)
    {
        $query = "select * from month m ";
        $query .= "where now() at time zone 'UTC' between (m.fecha_inicio at time zone '". $timezone ."' at time zone 'UTC')";
        $query .= "and ((m.fecha_fin + ((m.plazo)::text || ' day')::interval) at time zone '". $timezone ."' at time zone 'UTC')  ";
        $query .= "and id not in (select month_id from horas_hombre where contrato_id = :contrato_id)";

        $data = DB::select(DB::Raw($query),array('contrato_id'=> $contrato_id));

        return $data;
    }

    function getMesesDisponiblesForEstadisticas($timezone, $contrato_id)
    {
        $query = "select * from month m ";
        $query .= "where now()::timestamptz at time zone 'UTC' between (m.fecha_inicio at time zone '". $timezone ."' at time zone 'UTC')";
        $query .= "and ((m.fecha_fin + ((m.plazo)::text || ' day')::interval) at time zone '". $timezone ."' at time zone 'UTC')  ";
        $query .= "and id not in (select month_id from estadistica_seguridad where contrato_id = :contrato_id)";

        $data = DB::select(DB::Raw($query),array('contrato_id'=> $contrato_id));

        return $data;
    }

    function getMesesAmpliacion($solicita_id,$contrato_id)
    {
        $query = "select * from month where fecha_fin < now()::timestamptz at time zone 'UTC' and date_trunc('year',fecha_fin) = date_trunc('year',now()::timestamptz at time zone 'UTC') ";
        $query .= "and deleted_at is null and id not in(select month_id from prorroga_contrato where solicita_id = :solicita_id  and contrato_id = :contrato_id)";

        $data = DB::select(DB::Raw($query),array('solicita_id' => $solicita_id,'contrato_id'=> $contrato_id));

        return $data;
    }
}