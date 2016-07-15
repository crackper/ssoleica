<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 23/12/15
 * Time: 8:02 AM
 */

namespace SSOLeica\Core\Repository;


use Illuminate\Support\Facades\DB;
use SSOLeica\Core\Data\Repository;
use SSOLeica\Core\Model\Incidente;

class IncidenteRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\Incidente';
    }

    public function  getIncidentes($pais_id)
    {
        $query = Incidente::join('contrato as c','incidente.contrato_id','=','c.id')
                ->join('operacion as o','c.operacion_id','=','o.id')
                ->join('enum_tables as tf','incidente.tipo_informe_id','=','tf.id')
                ->join('enum_tables as ti','incidente.tipo_incidente_id','=','ti.id')
                ->where('o.pais_id','=',$pais_id)
                ->select('incidente.*')
                ->addSelect('c.nombre_contrato as contrato')
                ->addSelect('o.nombre_operacion as operacion')
                ->addSelect('o.id as operacion_id')
                ->addSelect('tf.name as tipo_informe')
                ->addSelect('ti.name as tipo_incidente');

        return $query;
    }

    public function getCorrelativo($pais_id,$fecha)
    {

        $query = "select case when max(i.id) is null ";
        $query .= "then (select upper(substr(p.name,1,2)) from enum_tables p where p.type = 'Pais' and id = :pais_id) || '-' || trim(to_char(1,'0000')) || '-' || date_part('year', '".$fecha."'::timestamp at time zone 'utc' at time zone (select (data->>0)::text as timezone from enum_tables where id = :pais_id)::text) ";
        $query .= "else (select upper(substr(p.name,1,2)) from enum_tables p where p.type = 'Pais' and id = :pais_id) || '-' || trim(to_char((max(substr(i.correlativo,4,4))::integer + 1),'0000')) || '-' || date_part('year', '".$fecha."'::timestamp at time zone 'utc' at time zone (select (data->>0)::text as timezone from enum_tables where id = :pais_id)::text)  end as next ";
        $query .= "from incidente i ";
        $query .= "where i.fecha between date_trunc('year', '".$fecha."'::timestamp at time zone 'utc' at time zone (select (data->>0)::text as timezone from enum_tables where id = :pais_id)::text) and (date_trunc('year', '".$fecha."'::timestamp at time zone 'utc' at time zone (select (data->>0)::text as timezone from enum_tables where id = :pais_id)::text) + interval '1 year' - interval '1 second') ";
        $query .= "and i.pais_id = :pais_id";

        $data = DB::select(DB::Raw($query),array('pais_id'=> $pais_id));

        return $data;
    }
}