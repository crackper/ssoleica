<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 13/05/15
 * Time: 9:21 AM
 */

namespace SSOLeica\Core\Repository;


use SSOLeica\Core\Data\Repository;
use SSOLeica\Core\Model\Contrato;

class ContratoRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\Contrato';
    }

    function getContratos($pais_id)
    {
        $query = Contrato::join('operacion','contrato.operacion_id','=','operacion.id')
                ->where('operacion.pais_id','=',$pais_id)
                ->select('contrato.*')
                ->addSelect('operacion.nombre_operacion as proyecto');

        return $query;
    }
}