<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 12/05/15
 * Time: 7:05 PM
 */

namespace SSOLeica\Core\Repository;


use SSOLeica\Core\Data\Repository;
use SSOLeica\Core\Model\Operacion;
use SSOLeica\Core\Model\TrabajadorOperacion;

class OperacionRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\Operacion';
    }

    /**
     * @param $pais_id
     * @return mixed
     */
    function getOperaciones($pais_id)
    {
        $query = Operacion::where('pais_id','=',$pais_id);

        return $query;
    }

    /**
     * @param $trabajador_id
     * @return array(all table)
     */
    public  function getOperacionesByTrabajador($trabajador_id)
    {
        $data = TrabajadorOperacion::where('trabajador_id','=',$trabajador_id)->get()
            ->load('operacion')->load('contratos');

        return $data;
    }

    /**
     * @param $trabajador_id
     * @return array(nombre_operacion,id)
     */
    public function getOperacionesDiponiblesByTrabajador($trabajador_id)
    {
        $in_operaciones = Operacion::join('contrato', 'contrato.operacion_id', '=', 'operacion.id')
            ->join('trabajador_contrato', 'trabajador_contrato.contrato_id', '=', 'contrato.id')
            ->select('operacion.id')
            ->where('trabajador_contrato.trabajador_id', '=', $trabajador_id)
            ->lists('id');

        $query = Operacion::whereNotIn('id', $in_operaciones)->lists('nombre_operacion', 'id');

        return $query;
    }
}