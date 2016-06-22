<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 23/12/15
 * Time: 8:02 AM
 */

namespace SSOLeica\Core\Repository;


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
}